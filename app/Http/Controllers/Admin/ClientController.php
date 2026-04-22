<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /* ─────────────────────────────────────────
     | Index — list view
     ───────────────────────────────────────── */

    public function index()
    {
        $stats = [
            'total'   => Client::withTrashed()->count(),
            'active'  => Client::where('active', true)->count(),
            'inactive'=> Client::where('active', false)->whereNull('deleted_at')->count(),
            'deleted' => Client::onlyTrashed()->count(),
        ];

        return view('admin.clients.index', compact('stats'));
    }

    /* ─────────────────────────────────────────
     | DataTables JSON endpoint
     ───────────────────────────────────────── */

    public function data(Request $request)
    {
        // Base query — support showing trashed via filter
        $query = Client::query();

        if ($request->get('show_deleted') === '1') {
            $query->onlyTrashed();
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('active', false);
            }
        }

        // Global search
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();
        $totalRecords  = Client::count();

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir      = $request->input('order.0.dir', 'asc');
        $columns       = ['id', 'name', 'company', 'email', 'phone', 'active'];
        $orderCol      = $columns[$orderColIndex] ?? 'name';

        $clients = $query->orderBy($orderCol, $orderDir)
            ->skip($request->input('start', 0))
            ->take($request->input('length', 10))
            ->with(['activeInvoices.completedItems', 'activeInvoices.proposedItems', 'activeInvoices.subscriptionItems'])
            ->get();

        $data = $clients->map(function (Client $client) {
            $balanceSummary = $client->outstandingBalanceSummary();

            return [
                'id'               => $client->id,
                'name'             => $client->name,
                'company'          => $client->company ?? '—',
                'email'            => $client->email,
                'phone'            => $client->phone ?? '—',
                'address'          => $client->address ?? '',
                'active_invoices'  => $client->activeInvoicesCount(),
                'outstanding'      => $balanceSummary['display'],
                'outstanding_sort' => $balanceSummary['sort_value'],
                'mixed_currency'   => $balanceSummary['mixed'],
                'status'           => $client->active ? 'active' : 'inactive',
                'deleted_at'       => $client->deleted_at,
                'edit_url'         => route('admin.clients.show', $client->id),
            ];
        });

        return response()->json([
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data,
        ]);
    }

    /* ─────────────────────────────────────────
     | Store — create new client
     ───────────────────────────────────────── */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:clients,email',
            'phone'   => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'active'  => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->boolean('active', true);

        $client = Client::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client created successfully.',
            'client'  => $client,
        ]);
    }

    /* ─────────────────────────────────────────
     | Show — client detail page
     ───────────────────────────────────────── */

    public function show(Client $client)
    {
        $invoices = $client->activeInvoices()
            ->with(['completedItems', 'proposedItems', 'subscriptionItems'])
            ->latest('submitted_at')
            ->get();

        // Build per-currency totals for the detail page
        $currencyTotals = [];
        foreach ($invoices as $invoice) {
            $currency = $invoice->currency ?? 'USD';
            if (!isset($currencyTotals[$currency])) {
                $currencyTotals[$currency] = [
                    'symbol'      => Invoice::$currencySymbols[$currency] ?? $currency,
                    'invoiced'    => 0,
                    'paid'        => 0,
                    'outstanding' => 0,
                ];
            }
            $currencyTotals[$currency]['invoiced']    += $invoice->completedSubtotal();
            $currencyTotals[$currency]['paid']        += (float) $invoice->paid_amount;
            $currencyTotals[$currency]['outstanding'] += $invoice->completedOutstanding();
        }

        return view('admin.clients.show', compact('client', 'invoices', 'currencyTotals'));
    }

    /* ─────────────────────────────────────────
     | Update — save edited client
     ───────────────────────────────────────── */

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:clients,email,' . $client->id,
            'phone'   => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'active'  => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->boolean('active', $client->active);

        $client->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client updated successfully.',
            'client'  => $client->fresh(),
        ]);
    }

    /* ─────────────────────────────────────────
     | Destroy — soft delete
     ───────────────────────────────────────── */

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client archived successfully.',
        ]);
    }

    /* ─────────────────────────────────────────
     | Restore — recover soft deleted client
     ───────────────────────────────────────── */

    public function restore(int $id)
    {
        $client = Client::onlyTrashed()->findOrFail($id);
        $client->restore();

        return response()->json([
            'success' => true,
            'message' => 'Client restored successfully.',
        ]);
    }
}
