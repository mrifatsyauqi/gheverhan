<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'description',
        'changed_at',
    ];

    protected function casts(): array
    {
        return [
            'changed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
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
}
