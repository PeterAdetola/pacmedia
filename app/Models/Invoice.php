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
        'has_proposed', 'has_subscription',
        'bank_name', 'bank_account_name', 'bank_account_number',
    ];

    protected $casts = [
        'submitted_at'            => 'date',
        'due_date'                => 'date',
        'tax_enabled'             => 'boolean',
        'wht_enabled'             => 'boolean',
        'has_proposed'            => 'boolean',
        'has_subscription'        => 'boolean',
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

    /**
     * Common currency symbols map.
     */
    public static array $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'NGN' => '₦',
        'GHS' => '₵',
        'KES' => 'KSh',
        'ZAR' => 'R',
        'CAD' => 'CA$',
        'AUD' => 'A$',
        'AED' => 'AED',
        'JPY' => '¥',
        'CNY' => '¥',
        'INR' => '₹',
    ];

    /**
     * Get the symbol for this invoice's currency.
     */
    public function currencySymbol(): string
    {
        return static::$currencySymbols[$this->currency ?? 'USD'] ?? ($this->currency ?? 'USD');
    }

    /**
     * Format an amount with this invoice's currency symbol.
     */
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
        return $this->hasMany(InvoiceItem::class)
            ->where('section', 'completed')
            ->orderBy('sort_order');
    }

    public function proposedItems()
    {
        return $this->hasMany(InvoiceItem::class)
            ->where('section', 'proposed')
            ->orderBy('sort_order');
    }

    public function subscriptionItems()
    {
        return $this->hasMany(InvoiceItem::class)
            ->where('section', 'subscription')
            ->orderBy('sort_order');
    }

    /* ─────────────────────────────────────────
     | Completed totals
     ───────────────────────────────────────── */

    public function completedSubtotal(): float
    {
        return $this->completedItems->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function completedTax(): float
    {
        if (!$this->tax_enabled) return 0;
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

    public function completedOutstanding(): float
    {
        return $this->completedSubtotal()
            + $this->completedTax()
            - $this->completed_discount
            - $this->paid_amount
            - $this->completedWht();
    }

    /* ─────────────────────────────────────────
     | Subscription totals
     ───────────────────────────────────────── */

    public function subscriptionSubtotal(): float
    {
        return $this->subscriptionItems->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function subscriptionTax(): float
    {
        if (!$this->tax_enabled) return 0;
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
            - $this->subscription_discount;
    }

    /* ─────────────────────────────────────────
     | Proposed totals
     ───────────────────────────────────────── */

    public function proposedSubtotal(): float
    {
        return $this->proposedItems->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function proposedTax(): float
    {
        if (!$this->tax_enabled) return 0;
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
            - $this->proposed_discount;
    }

    /* ─────────────────────────────────────────
     | Invoice number generator
     ───────────────────────────────────────── */

    public static function generateNumber(): string
    {
        $prefix = 'P' . now()->format('dmY');
        $last   = static::withTrashed()
            ->where('number', 'like', $prefix . '%')
            ->orderByDesc('number')
            ->value('number');

        $seq = $last ? ((int) substr($last, -3)) + 1 : 1;

        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }
}
