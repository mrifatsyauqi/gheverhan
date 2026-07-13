<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'status',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
        'shipping_method',
        'tracking_number',
        'payment_method',
        'payment_status',
        'notes',
        'shipping_address_snapshot',
        'paid_at',
        'shipped_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'shipping_cost' => 'integer',
            'discount' => 'integer',
            'total' => 'integer',
            'paid_at' => 'datetime',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    /* ---------- Relationships ---------- */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('changed_at');
    }

    /* ---------- Accessors ---------- */

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pesanan Dibuat',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Dikemas',
            'shipped' => 'Dikirim',
            'delivered' => 'Sampai Tujuan',
            'cancelled' => 'Dibatalkan',
            'refunded' => 'Dikembalikan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-gray-100 text-gray-700',
            'confirmed', 'processing' => 'bg-yellow-50 text-yellow-700',
            'shipped' => 'bg-blue-50 text-blue-700',
            'delivered' => 'bg-green-50 text-green-700',
            'cancelled', 'refunded' => 'bg-red-50 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /* ---------- Helpers ---------- */

    public static function generateOrderNumber(): string
    {
        $prefix = 'GHV';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        return "{$prefix}-{$date}-{$random}";
    }
}
