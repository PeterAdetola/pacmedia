<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* ─────────────────────────────────────────
       Relationships
       ───────────────────────────────────────── */

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function activeInvoices()
    {
        return $this->hasMany(Invoice::class)->whereNull('deleted_at');
    }

    /* ─────────────────────────────────────────
       Accessors
       ───────────────────────────────────────── */

    public function getDisplayNameAttribute(): string
    {
        return $this->company
            ? "{$this->name} ({$this->company})"
            : $this->name;
    }

    /* ─────────────────────────────────────────
       Invoice Stats
       ───────────────────────────────────────── */

    /**
     * Count of non-deleted invoices for this client.
     */
    public function activeInvoicesCount(): int
    {
        return $this->activeInvoices()->count();
    }

    /**
     * Outstanding balance summary across all active invoices.
     */
    public function outstandingBalanceSummary(): array
    {
        $invoices = $this->activeInvoices()->with(['completedItems', 'proposedItems', 'subscriptionItems'])->get();

        $totals = [];

        foreach ($invoices as $invoice) {
            $currency = $invoice->currency ?? 'USD';
            $balance  = $invoice->completedOutstanding();

            if (!isset($totals[$currency])) {
                $totals[$currency] = 0;
            }

            $totals[$currency] += $balance;
        }

        $currencies = array_keys($totals);
        $mixed      = count($currencies) > 1;

        // Build display string
        if (empty($totals)) {
            $display = '—';
        } elseif ($mixed) {
            $parts = [];
            foreach ($totals as $code => $amount) {
                $symbol  = Invoice::$currencySymbols[$code] ?? $code;
                $parts[] = $symbol . ' ' . number_format($amount, 2);
            }
            $display = implode(' / ', $parts);
        } else {
            $code    = $currencies[0];
            $symbol  = Invoice::$currencySymbols[$code] ?? $code;
            $display = $symbol . ' ' . number_format($totals[$code], 2);
        }

        return [
            'mixed'      => $mixed,
            'currencies' => $currencies,
            'totals'     => $totals,
            'display'    => $display,
            'sort_value' => array_sum($totals),
        ];
    }

    /**
     * Quick display string for outstanding balance.
     */
    public function outstandingBalanceDisplay(): string
    {
        return $this->outstandingBalanceSummary()['display'];
    }

    /**
     * Numeric sort value for outstanding balance.
     */
    public function outstandingBalanceSortValue(): float
    {
        return $this->outstandingBalanceSummary()['sort_value'];
    }
}
