<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'base_cost',
        'estimated_days',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'base_cost' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getFormattedCostAttribute(): string
    {
        return $this->base_cost > 0 
            ? 'Rp ' . number_format($this->base_cost, 0, ',', '.')
            : 'Gratis';
    }
}
