<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendInvoiceEmail;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('client', 'items')
            ->whereNull('deleted_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        if ($request->filled('period')) {
            match ($request->period) {
                'today'      => $query->whereDate('submitted_at', today()),
                'this_week'  => $query->whereBetween('submitted_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'this_month' => $query->whereMonth('submitted_at', now()->month)->whereYear('submitted_at', now()->year),
                'last_month' => $query->whereMonth('submitted_at', now()->subMonth()->month)->whereYear('submitted_at', now()->subMonth()->year),
                'this_year'  => $query->whereYear('submitted_at', now()->year),
                default      => null,
            };
        }
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('number', 'like', $term)
                    ->orWhere('project_name', 'like', $term)
                    ->orWhereHas('client', fn($cq) => $cq->where('name', 'like', $term)
                        ->orWhere('company', 'like', $term));
            });
        }

        $query->orderByDesc('submitted_at')->orderByDesc('id');
        $perPage  = (int) $request->input('per_page', 10);
        $invoices = $query->paginate($perPage)->withQueryString();

        $allInvoices = Invoice::whereNull('deleted_at');
        $stats = [
            'total'             => (clone $allInvoices)->count(),
            'this_month'        => (clone $allInvoices)->whereMonth('submitted_at', now()->month)->whereYear('submitted_at', now()->year)->count(),
            'draft_count'       => (clone $allInvoices)->where('status', 'draft')->count(),
            'sent_count'        => (clone $allInvoices)->where('status', 'sent')->count(),
            'partial_count'     => (clone $allInvoices)->where('status', 'partial')->count(),
            'paid_count'        => (clone $allInvoices)->where('status', 'paid')->count(),
            'overdue_count'     => (clone $allInvoices)->where('status', 'overdue')->count(),
            'client_count'      => Client::where('active', true)->count(),
            'total_billed'      => Invoice::whereNull('deleted_at')->with('items')->get()
                ->sum(fn($inv) => $inv->completedSubtotal()),
            'total_outstanding' => Invoice::whereNull('deleted_at')->whereNotIn('status', ['paid'])->with('items')->get()
                ->sum(fn($inv) => max(0, $inv->completedOutstanding())),
        ];

        $clients = Client::where('active', true)->orderBy('name')->get();

        return view('admin.invoices.index', compact('invoices', 'stats', 'clients'));
    }

    public function create(Request $request)
    {
        $clients           = Client::orderBy('name')->get();
        $preselectedClient = $request->filled('client_id')
            ? Client::find($request->client_id)
            : null;

        return view('admin.invoices.create', compact('clients', 'preselectedClient'));
    }

    /* ─────────────────────────────────────────────────────────
     | Shared validation rules
     ───────────────────────────────────────────────────────── */
    private function validationRules(): array
    {
        return [
            // 'number' is generated server-side — not a user-submitted field
            'client_id'                     => 'required|exists:clients,id',
            'project_name'                  => 'nullable|string|max:255',
            'submitted_at'                  => 'required|date',
            'due_date'                      => 'required|string|max:100',
            'status'                        => 'required|in:draft,sent,partial,paid,overdue',
            'paid_amount'                   => 'nullable|numeric|min:0',

            // Completed
            'has_completed'                 => 'boolean',  // FIX: was missing from rules
            'completed_discount'            => 'nullable|numeric|min:0',
            'completed_discount_label'      => 'nullable|string|max:255',

            // Subscription
            'has_subscription'              => 'boolean',
            'subscription_discount'         => 'nullable|numeric|min:0',
            'subscription_discount_label'   => 'nullable|string|max:255',

            // Proposed
            'has_proposed'                  => 'boolean',
            'proposed_discount'             => 'nullable|numeric|min:0',
            'proposed_discount_label'       => 'nullable|string|max:255',

            // Tax / WHT
            'tax_enabled'                   => 'boolean',
            'tax_label'                     => 'nullable|string|max:50',
            'tax_rate'                      => 'nullable|numeric|min:0|max:100',
            'tax_applies_to'                => 'nullable|in:completed,proposed,subscription,both,all',
            'wht_enabled'                   => 'boolean',
            'wht_label'                     => 'nullable|string|max:50',
            'wht_rate'                      => 'nullable|numeric|min:0|max:100',

            // Notes
            'subscription_notes'            => 'nullable|string',
            'completed_notes'               => 'nullable|string',
            'proposed_notes'                => 'nullable|string',

            // Bank
            'bank_name'                     => 'nullable|string|max:255',
            'bank_account_name'             => 'nullable|string|max:255',
            'bank_account_number'           => 'nullable|string|max:50',

            // Completed items
            'completed_items'               => 'nullable|array',
            'completed_items.*.description' => 'required|string|max:500',
            'completed_items.*.qty'         => 'required|numeric|min:0',
            'completed_items.*.unit_price'  => 'required|numeric|min:0',
            'completed_items.*.taxable'     => 'boolean',

            // Subscription items
            'subscription_items'                  => 'nullable|array',
            'subscription_items.*.description'    => 'required|string|max:500',
            'subscription_items.*.qty'            => 'required|numeric|min:0',
            'subscription_items.*.unit_price'     => 'required|numeric|min:0',
            'subscription_items.*.billing_cycle'  => 'nullable|in:monthly,annual',
            'subscription_items.*.renewal_date'   => 'nullable|date',
            'subscription_items.*.taxable'        => 'boolean',

            // Proposed items
            'proposed_items'                => 'nullable|array',
            'proposed_items.*.description'  => 'required|string|max:500',
            'proposed_items.*.qty'          => 'required|numeric|min:0',
            'proposed_items.*.unit_price'   => 'required|numeric|min:0',
            'proposed_items.*.taxable'      => 'boolean',

            // Currency
            'currency' => 'required|string|size:3',
        ];
    }

    /* ─────────────────────────────────────────────────────────
     | Shared invoice attribute builder
     ───────────────────────────────────────────────────────── */
    private function invoiceAttributes(array $v): array
    {
        return [
            'client_id'                   => $v['client_id'],
            'project_name'                => $v['project_name']                  ?? null,
            'submitted_at'                => $v['submitted_at'],
            'due_date'                    => $v['due_date'],
            'status'                      => $v['status'],
            'paid_amount'                 => $v['paid_amount']                   ?? 0,
            'completed_discount'          => $v['completed_discount']            ?? 0,
            'completed_discount_label'    => $v['completed_discount_label']      ?? null,
            'has_completed'               => $v['has_completed']                 ?? false,  // FIX: now sourced correctly
            'has_proposed'                => $v['has_proposed']                  ?? false,
            'has_subscription'            => $v['has_subscription']              ?? false,
            'subscription_discount'       => $v['subscription_discount']         ?? 0,
            'subscription_discount_label' => $v['subscription_discount_label']   ?? null,
            'subscription_notes'          => $v['subscription_notes']            ?? null,
            'proposed_discount'           => $v['proposed_discount']             ?? 0,
            'proposed_discount_label'     => $v['proposed_discount_label']       ?? null,
            'tax_enabled'                 => $v['tax_enabled']                   ?? false,
            'tax_label'                   => $v['tax_label']                     ?? 'VAT',
            'tax_rate'                    => $v['tax_rate']                      ?? 7.50,
            'tax_applies_to'              => $v['tax_applies_to']                ?? 'completed',
            'wht_enabled'                 => $v['wht_enabled']                   ?? false,
            'wht_label'                   => $v['wht_label']                     ?? 'WHT (5%)',
            'wht_rate'                    => $v['wht_rate']                      ?? 5.00,
            'completed_notes'             => $v['completed_notes']               ?? null,
            'proposed_notes'              => $v['proposed_notes']                ?? null,
            'bank_name'                   => $v['bank_name']                     ?? null,
            'bank_account_name'           => $v['bank_account_name']             ?? null,
            'bank_account_number'         => $v['bank_account_number']           ?? null,
            'currency'                    => $v['currency']                      ?? 'NGN',
        ];
    }

    /* ─────────────────────────────────────────────────────────
     | Save all item sections for a given invoice
     ───────────────────────────────────────────────────────── */
    private function saveItems(Invoice $invoice, array $validated, bool $deleteFirst = false): void
    {
        if ($deleteFirst) {
            $invoice->items()->delete();
        }

        foreach (['completed', 'proposed', 'subscription'] as $section) {
            foreach (($validated["{$section}_items"] ?? []) as $i => $item) {
                $invoice->items()->create([
                    'invoice_id'    => $invoice->id,
                    'section'       => $section,
                    'description'   => $item['description'],
                    'qty'           => $item['qty'],
                    'unit_price'    => $item['unit_price'],
                    'taxable'       => isset($item['taxable']) && $item['taxable'],
                    'sort_order'    => $i,
                    'billing_cycle' => $item['billing_cycle'] ?? null,
                    'renewal_date'  => $item['renewal_date']  ?? null,
                ]);
            }
        }
    }

    /* ─────────────────────────────────────────────────────────
     | Build a default email subject & body for an invoice
     ───────────────────────────────────────────────────────── */
    private function defaultEmailContent(Invoice $invoice): array
    {
        $invoice->loadMissing(['client', 'completedItems', 'subscriptionItems', 'proposedItems']);

        $subject = 'Invoice ' . $invoice->number . ' — The Pacmedia'
            . ($invoice->project_name ? ' · ' . $invoice->project_name : '');

        // Build a breakdown that only mentions sections that have a balance
        $lines = [];

        if ($invoice->has_completed && $invoice->completedSubtotal() > 0) {
            $outstanding = max(0, $invoice->completedOutstanding());
            $lines[] = "Completed services outstanding: " . $invoice->formatAmount($outstanding);
        }

        if ($invoice->has_subscription && $invoice->subscriptionSubtotal() > 0) {
            $lines[] = "Subscription total: " . $invoice->formatAmount($invoice->subscriptionOutstanding());
        }

        if ($invoice->has_proposed && $invoice->proposedSubtotal() > 0) {
            $lines[] = "Proposed services total: " . $invoice->formatAmount($invoice->proposedTotal());
        }

        // Grand outstanding (completed + subscription only — proposed is not yet approved)
        $grandOutstanding = max(0, $invoice->grandOutstanding());

        $amountBlock = implode("\n", $lines);
        if (count($lines) > 1) {
            $amountBlock .= "\n" . str_repeat('─', 36)
                . "\nTotal outstanding: " . $invoice->formatAmount($grandOutstanding);
        }

        $message = "Dear {$invoice->client->name},\n\n"
            . "Please find attached Invoice {$invoice->number}"
            . ($invoice->project_name ? " for {$invoice->project_name}" : '') . ".\n\n"
            . $amountBlock . "\n"
            . "Due: {$invoice->due_date}\n\n"
            . "Kindly process payment at your earliest convenience.\n\n"
            . "Warm regards,\nPeter\nThe Pacmedia";

        return compact('subject', 'message');
    }

    /* ─────────────────────────────────────────────────────────
     | STORE
     ───────────────────────────────────────────────────────── */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        $action = $request->input('status_action', 'draft');
        $validated['status'] = match ($action) {
            'sent'          => 'sent',
            'preview_draft' => 'draft',
            default         => $validated['status'],
        };

        $invoice = DB::transaction(function () use ($validated) {
            $attrs           = $this->invoiceAttributes($validated);
            $attrs['number'] = Invoice::generateNumber();
            $invoice         = Invoice::create($attrs);
            $this->saveItems($invoice, $validated);
            return $invoice;
        });

        if ($action === 'sent') {
            $invoice->load(['client', 'completedItems', 'subscriptionItems', 'proposedItems']);
            ['subject' => $subject, 'message' => $message] = $this->defaultEmailContent($invoice);
            SendInvoiceEmail::dispatch($invoice, $subject, $message);
        }

        if ($action === 'preview_draft') {
            return redirect()
                ->route('admin.invoices.preview', $invoice)
                ->with('success', 'Invoice saved as draft.');
        }

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice ' . $invoice->number . ' created successfully.');
    }

    /* ─────────────────────────────────────────────────────────
     | SHOW
     ───────────────────────────────────────────────────────── */
    public function show(Invoice $invoice)
    {
        $invoice->load([
            'client',
            'completedItems'    => fn($q) => $q->orderBy('sort_order'),
            'subscriptionItems' => fn($q) => $q->orderBy('sort_order'),
            'proposedItems'     => fn($q) => $q->orderBy('sort_order'),
        ]);

        return view('admin.invoices.show', compact('invoice'));
    }

    /* ─────────────────────────────────────────────────────────
     | PREVIEW
     ───────────────────────────────────────────────────────── */
    public function preview(Invoice $invoice)
    {
        $invoice->load([
            'client',
            'completedItems'    => fn($q) => $q->orderBy('sort_order'),
            'subscriptionItems' => fn($q) => $q->orderBy('sort_order'),
            'proposedItems'     => fn($q) => $q->orderBy('sort_order'),
        ]);

        return view('admin.invoices.pdf', compact('invoice'));
    }

    /* ─────────────────────────────────────────────────────────
     | EDIT
     ───────────────────────────────────────────────────────── */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['completedItems', 'subscriptionItems', 'proposedItems']);
        $clients = Client::orderBy('name')->get();
        return view('admin.invoices.edit', compact('invoice', 'clients'));
    }

    /* ─────────────────────────────────────────────────────────
     | UPDATE
     ───────────────────────────────────────────────────────── */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate($this->validationRules());

        $action = $request->input('status_action', 'draft');
        $validated['status'] = match ($action) {
            'sent'          => 'sent',
            'preview_draft' => 'draft',
            default         => $validated['status'],
        };

        DB::transaction(function () use ($invoice, $validated) {
            $invoice->update($this->invoiceAttributes($validated));
            $this->saveItems($invoice, $validated, deleteFirst: true);
        });

        if ($action === 'sent') {
            // FIX: reload after transaction so relations + attributes are fresh
            $fresh = $invoice->fresh()->load(['client', 'completedItems', 'subscriptionItems', 'proposedItems']);
            ['subject' => $subject, 'message' => $message] = $this->defaultEmailContent($fresh);
            SendInvoiceEmail::dispatch($fresh, $subject, $message);
        }

        if ($action === 'preview_draft') {
            return redirect()
                ->route('admin.invoices.preview', $invoice)
                ->with('success', 'Invoice saved.');
        }

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    /* ─────────────────────────────────────────────────────────
     | DESTROY
     ───────────────────────────────────────────────────────── */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted.');
    }

    /* ─────────────────────────────────────────────────────────
     | DUPLICATE
     ───────────────────────────────────────────────────────── */
    public function duplicate(Invoice $invoice)
    {
        $invoice->load(['completedItems', 'subscriptionItems', 'proposedItems']);

        // FIX: capture $new via return value instead of $this->_invoice
        $newInvoice = DB::transaction(function () use ($invoice) {
            $new               = $invoice->replicate();
            $new->number       = Invoice::generateNumber();
            $new->status       = 'draft';
            $new->submitted_at = now();
            $new->paid_amount  = 0;
            $new->save();

            $fields = ['section', 'description', 'qty', 'unit_price', 'billing_cycle', 'renewal_date', 'taxable', 'sort_order'];

            foreach ($invoice->completedItems    as $item) { $new->items()->create($item->only($fields)); }
            foreach ($invoice->subscriptionItems as $item) { $new->items()->create($item->only($fields)); }
            foreach ($invoice->proposedItems     as $item) { $new->items()->create($item->only($fields)); }

            return $new;  // FIX: return instead of assigning to $this->_invoice
        });

        return redirect()
            ->route('admin.invoices.edit', $newInvoice)
            ->with('success', 'Invoice duplicated. Review and save.');
    }

    /* ─────────────────────────────────────────────────────────
     | RECORD PAYMENT
     ───────────────────────────────────────────────────────── */
    public function recordPayment(Request $request, Invoice $invoice)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        $invoice->increment('paid_amount', $request->amount);

        // Reload to get accurate outstanding after increment
        $invoice->refresh();
        $invoice->loadMissing(['completedItems', 'subscriptionItems', 'proposedItems']);

//        $outstanding = $invoice->completedOutstanding();
        $outstanding = $invoice->grandOutstanding();
        if ($outstanding <= 0) {
            $invoice->update(['status' => 'paid']);
        } elseif ($invoice->paid_amount > 0) {
            $invoice->update(['status' => 'partial']);
        }

        // FIX: use the invoice's actual currency symbol instead of hardcoded ₦
        return back()->with('success', $invoice->formatAmount($request->amount) . ' payment recorded.');
    }

    /* ─────────────────────────────────────────────────────────
     | PDF
     ───────────────────────────────────────────────────────── */
    public function pdf(Invoice $invoice)
    {
        $invoice->load([
            'client',
            'completedItems'    => fn($q) => $q->orderBy('sort_order'),
            'subscriptionItems' => fn($q) => $q->orderBy('sort_order'),
            'proposedItems'     => fn($q) => $q->orderBy('sort_order'),
        ]);

        $html = view('admin.invoices.pdf', compact('invoice'))->render();

        $response = Http::timeout(45)->withHeaders([
            'Cache-Control' => 'no-cache',
            'Content-Type'  => 'application/json',
        ])->post('https://chrome.browserless.io/pdf?token=' . config('services.browserless.token'), [
            'html'    => $html,
            'options' => [
                'format'          => 'A4',
                'landscape'       => false,
                'printBackground' => true,
                'margin'          => ['top' => '0mm', 'right' => '0mm', 'bottom' => '0mm', 'left' => '0mm'],
            ],
        ]);

        if (!$response->successful()) {
            abort(502, 'PDF generation failed: Browserless returned HTTP ' . $response->status());
        }

        $filename = 'invoice-' . $invoice->number . '.pdf';

        return response($response->body(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Length'      => strlen($response->body()),
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
        ]);
    }

    /* ─────────────────────────────────────────────────────────
     | SEND EMAIL
     ───────────────────────────────────────────────────────── */
    public function send(Request $request, Invoice $invoice)
    {
        if (!$invoice->client->email) {
            return back()->withErrors(['email' => 'This client has no email address on record.']);
        }

        $request->validate([
            'from_address' => 'required|email',
            'subject'      => 'required|string|max:255',
            'message'      => 'required|string',
        ]);

        // Whitelist — only allow your own configured sender addresses
        $allowed = array_column(config('mail.from_addresses', []), 'address');
        if (!in_array($request->from_address, $allowed)) {
            return back()->withErrors(['from_address' => 'Invalid sender address.']);
        }

        // FIX: load all relations needed for PDF generation in the queued job
        $invoice->load(['client', 'completedItems', 'subscriptionItems', 'proposedItems']);

        SendInvoiceEmail::dispatch(
            $invoice,
            $request->input('subject'),
            $request->input('message'),
            $request->input('from_address'),
        );

        $invoice->update(['status' => 'sent']);

        return back()->with('success', "Invoice #{$invoice->number} sent to {$invoice->client->email}.");
    }
}
