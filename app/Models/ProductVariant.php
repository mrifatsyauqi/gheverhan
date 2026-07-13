<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'color',
        'size',
        'price_adjustment',
        'stock',
        'sku',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_adjustment' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /* ---------- Relationships ---------- */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /* ---------- Accessors ---------- */

    public function getFinalPriceAttribute(): int
    {
        return $this->product->price + $this->price_adjustment;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    public function isInStock(): bool
    {
        return $this->is_active && $this->stock > 0;
    }
}
