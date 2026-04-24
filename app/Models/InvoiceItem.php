<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_id', 'section', 'description',
        'qty', 'unit_price', 'taxable', 'sort_order', 'billing_cycle',
        'renewal_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'taxable'      => 'boolean',
        'unit_price'   => 'decimal:2',
        'renewal_date' => 'date',
        'qty'          => 'decimal:2',
    ];

    /**
     * Ensure that the parent Invoice's updated_at timestamp is touched
     * whenever an item is updated or created.
     */
    protected $touches = ['invoice'];

    /**
     * Get the invoice that owns the item.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Calculate the total for this item.
     */
    public function total(): float
    {
        return (float) ($this->qty * $this->unit_price);
    }
}
