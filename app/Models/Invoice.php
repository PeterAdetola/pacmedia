<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number', 'client_id', 'project_name', 'submitted_at', 'due_date', 'status',
        'currency',
        'paid_amount',
        'completed_discount', 'completed_discount_label',
        'proposed_discount',  'proposed_discount_label',
        'subscription_discount', 'subscription_discount_label',
        'tax_enabled', 'tax_label', 'tax_rate', 'tax_applies_to',
        'wht_enabled', 'wht_label', 'wht_rate',
        'completed_notes', 'proposed_notes', 'subscription_notes',
        'has_proposed', 'has_subscription', 'has_completed',
        'bank_name', 'bank_account_name', 'bank_account_number', 'billing_cycle', 'renewal_date'
    ];

    protected $casts = [
        'submitted_at'            => 'date',
        'tax_enabled'             => 'boolean',
        'wht_enabled'             => 'boolean',
        'has_proposed'            => 'boolean',
        'has_subscription'        => 'boolean',
        'has_completed'           => 'boolean',
        'paid_amount'             => 'decimal:2',
        'completed_discount'      => 'decimal:2',
        'proposed_discount'       => 'decimal:2',
        'subscription_discount'   => 'decimal:2',
        'tax_rate'                => 'decimal:2',
        'wht_rate'                => 'decimal:2',
    ];

    /* ─────────────────────────────────────────
     | Currency helpers
     ───────────────────────────────────────── */

    public static array $currencySymbols = [
        'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'NGN' => '₦', 'GHS' => '₵',
        'KES' => 'KSh', 'ZAR' => 'R', 'CAD' => 'CA$', 'AUD' => 'A$', 'AED' => 'AED',
        'JPY' => '¥', 'CNY' => '¥', 'INR' => '₹',
    ];

    public function currencySymbol(): string
    {
        return static::$currencySymbols[$this->currency ?? 'NGN'] ?? ($this->currency ?? 'NGN');
    }

    public function formatAmount(float $amount): string
    {
        return $this->currencySymbol() . ' ' . number_format($amount, 2);
    }

    /* ─────────────────────────────────────────
     | Relationships
     ───────────────────────────────────────── */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('sort_order');
    }

    public function completedItems()
    {
        return $this->hasMany(InvoiceItem::class)->where('section', 'completed')->orderBy('sort_order');
    }

    public function proposedItems()
    {
        return $this->hasMany(InvoiceItem::class)->where('section', 'proposed')->orderBy('sort_order');
    }

    public function subscriptionItems()
    {
        return $this->hasMany(InvoiceItem::class)->where('section', 'subscription')->orderBy('sort_order');
    }

    /* ─────────────────────────────────────────
     | Sectional Totals — Completed
     ───────────────────────────────────────── */

    public function completedSubtotal(): float
    {
        return (float) $this->completedItems->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function completedTax(): float
    {
        if (!$this->tax_enabled) return 0;
        // FIX: 'all' added consistently (was missing in the original completedTax check)
        if (!in_array($this->tax_applies_to, ['completed', 'both', 'all'])) return 0;

        return round(
            $this->completedItems->where('taxable', true)->sum(fn($i) => $i->qty * $i->unit_price)
            * ($this->tax_rate / 100),
            2
        );
    }

    public function completedWht(): float
    {
        if (!$this->wht_enabled) return 0;
        return round($this->completedSubtotal() * ($this->wht_rate / 100), 2);
    }

    /**
     * What the client still owes for the Completed section.
     * Formula: subtotal + tax − discount − paid_amount − WHT
     *
     * NOTE: paid_amount and WHT are intentionally applied only to the
     * completed section because that is the payable/billable section.
     * Subscription is a recurring charge; Proposed is not yet approved.
     */
    public function completedOutstanding(): float
    {
        return $this->completedSubtotal()
            + $this->completedTax()
            - (float) $this->completed_discount
            - (float) $this->paid_amount
            - $this->completedWht();
    }

    /* ─────────────────────────────────────────
     | Sectional Totals — Subscription
     ───────────────────────────────────────── */

    public function subscriptionSubtotal(): float
    {
        return (float) $this->subscriptionItems->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function subscriptionTax(): float
    {
        if (!$this->tax_enabled) return 0;
        // FIX: 'both' intentionally NOT included here — 'both' = completed + proposed only
        if (!in_array($this->tax_applies_to, ['subscription', 'all'])) return 0;

        return round(
            $this->subscriptionItems->where('taxable', true)->sum(fn($i) => $i->qty * $i->unit_price)
            * ($this->tax_rate / 100),
            2
        );
    }

    public function subscriptionOutstanding(): float
    {
        return $this->subscriptionSubtotal()
            + $this->subscriptionTax()
            - (float) $this->subscription_discount;
    }

    /* ─────────────────────────────────────────
     | Sectional Totals — Proposed
     ───────────────────────────────────────── */

    public function proposedSubtotal(): float
    {
        return (float) $this->proposedItems->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function proposedTax(): float
    {
        if (!$this->tax_enabled) return 0;
        // 'both' means completed + proposed; 'all' means everything
        if (!in_array($this->tax_applies_to, ['proposed', 'both', 'all'])) return 0;

        return round(
            $this->proposedItems->where('taxable', true)->sum(fn($i) => $i->qty * $i->unit_price)
            * ($this->tax_rate / 100),
            2
        );
    }

    public function proposedTotal(): float
    {
        return $this->proposedSubtotal()
            + $this->proposedTax()
            - (float) $this->proposed_discount;
    }

    /* ─────────────────────────────────────────
     | Combined / Grand Totals
     ───────────────────────────────────────── */

    public function totalSubtotal(): float
    {
        return $this->completedSubtotal() + $this->subscriptionSubtotal();
    }

    public function grandTotal(): float
    {
        $completedNet    = $this->completedSubtotal() + $this->completedTax() - (float) $this->completed_discount;
        $subscriptionNet = $this->subscriptionSubtotal() + $this->subscriptionTax() - (float) $this->subscription_discount;
        return $completedNet + $subscriptionNet;
    }

    /**
     * Grand outstanding = what is owed across Completed + Subscription,
     * minus payment already received and WHT deduction.
     *
     * FIX: removed the double-subtraction of WHT that existed in the original.
     * completedWht() is already subtracted inside completedOutstanding(),
     * so grandOutstanding() must NOT subtract it a second time.
     */
    public function grandOutstanding(): float
    {
        $totalDue = $this->completedSubtotal()
            + $this->completedTax()
            - (float) $this->completed_discount
            + $this->subscriptionSubtotal()
            + $this->subscriptionTax()
            - (float) $this->subscription_discount
            - $this->completedWht();

        return $totalDue - (float) $this->paid_amount;
    }

    /* ─────────────────────────────────────────
     | Invoice Number Generator
     ───────────────────────────────────────── */

    public static function generateNumber(): string
    {
        $prefix = 'P' . now()->format('dmY');
        $last   = static::withTrashed()
            ->where('number', 'like', $prefix . '%')
            ->orderByDesc('number')
            ->value('number');
        $seq = $last ? ((int) substr($last, -3)) + 1 : 1;

        // Guard against race conditions: keep incrementing until the number is free
        do {
            $number = $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
            $exists = static::withTrashed()->where('number', $number)->exists();
            $seq++;
        } while ($exists);

        return $number;
    }
}
