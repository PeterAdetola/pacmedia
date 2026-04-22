<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'section', 'description',
        'qty', 'unit_price', 'taxable', 'sort_order',
    ];

    protected $casts = [
        'taxable'    => 'boolean',
        'unit_price' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function total(): float
    {
        return $this->qty * $this->unit_price;
    }
}
