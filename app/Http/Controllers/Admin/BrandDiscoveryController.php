<?php
// app/Http/Controllers/Admin/BrandDiscoveryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrandDiscovery;
use Illuminate\Http\Request;

class BrandDiscoveryController extends Controller
{
    public function index(Request $request)
    {
        $query = BrandDiscovery::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('brand_name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('industry', 'like', $term);
            });
        }

        $query->orderByDesc('created_at');
        $perPage    = (int) $request->input('per_page', 10);
        $discoveries = $query->paginate($perPage)->withQueryString();

        $all = BrandDiscovery::query();
        $stats = [
            'total'         => (clone $all)->count(),
            'this_month'    => (clone $all)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'new_count'     => (clone $all)->where('status', 'new')->count(),
            'reviewed_count'=> (clone $all)->where('status', 'reviewed')->count(),
            'archived_count'=> (clone $all)->where('status', 'archived')->count(),
        ];

        return view('admin.brand-discoveries.index', compact('discoveries', 'stats'));
    }

    public function show(BrandDiscovery $brandDiscovery)
    {
        return view('admin.brand-discoveries.show', ['discovery' => $brandDiscovery]);
    }

    public function createLink(Request $request)
    {
        $request->validate([
            'name'         => 'nullable|string|max:255',
            'brand_name'   => 'nullable|string|max:255',
            'email'        => 'nullable|email|max:255',
            'client_token' => 'nullable|string|max:255',
        ]);

        $discovery = BrandDiscovery::create([
            'name'         => $request->name,
            'brand_name'   => $request->brand_name,
            'email'        => $request->email,
            'client_token' => $request->client_token,
            'token'        => BrandDiscovery::generateToken(),
            'status'       => 'sent',
            'expires_at'   => now()->addDays(BrandDiscovery::DEFAULT_EXPIRY_DAYS),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Link generated.',
            'url'     => route('brand-discovery.show-token', $discovery->token),
        ]);
    }

    public function updateStatus(Request $request, BrandDiscovery $brandDiscovery)
    {
        $request->validate(['status' => 'required|in:new,reviewed,archived']);

        $brandDiscovery->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Marked as ' . $request->status . '.',
        ]);
    }

    public function destroy(BrandDiscovery $brandDiscovery)
    {
        $brandDiscovery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Submission deleted.',
        ]);
    }

    public function expireNow(BrandDiscovery $brandDiscovery)
    {
        if (!$brandDiscovery->token) {
            return response()->json(['success' => false, 'message' => 'This submission has no link to expire.'], 422);
        }

        if ($brandDiscovery->isSubmitted()) {
            return response()->json(['success' => false, 'message' => 'This link was already submitted — nothing to expire.'], 422);
        }

        if ($brandDiscovery->isExpired()) {
            return response()->json(['success' => false, 'message' => 'This link is already expired.'], 422);
        }

        $brandDiscovery->update([
            'expires_at' => now()->subMinute(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Link expired. It can be renewed anytime.',
        ]);
    }

    public function renew(BrandDiscovery $brandDiscovery)
    {
        if (!$brandDiscovery->token) {
            return response()->json(['success' => false, 'message' => 'This submission has no link to renew.'], 422);
        }

        if ($brandDiscovery->isSubmitted()) {
            return response()->json(['success' => false, 'message' => 'This link was already submitted — use Reopen instead.'], 422);
        }

        $brandDiscovery->update([
            'expires_at' => now()->addDays(BrandDiscovery::DEFAULT_EXPIRY_DAYS),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Link renewed for another ' . BrandDiscovery::DEFAULT_EXPIRY_DAYS . ' days.',
        ]);
    }
}
