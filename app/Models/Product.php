<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'sku',
        'stock',
        'weight',
        'images',
        'rating',
        'rating_count',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'compare_price' => 'integer',
            'images' => 'array',
            'rating' => 'decimal:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    /* ---------- Relationships ---------- */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /* ---------- Scopes ---------- */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    /* ---------- Accessors ---------- */

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedComparePriceAttribute(): ?string
    {
        if (!$this->compare_price) {
            return null;
        }
        return 'Rp ' . number_format($this->compare_price, 0, ',', '.');
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->compare_price || $this->compare_price <= $this->price) {
            return null;
        }
        return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }

    public function getPrimaryImageAttribute(): string
    {
        $images = $this->images;
        return $images[0] ?? 'https://placehold.co/600x600/F2F2F2/111111?text=No+Image';
    }

    public function getAvailableColorsAttribute(): array
    {
        return $this->variants()
            ->where('is_active', true)
            ->whereNotNull('color')
            ->distinct()
            ->pluck('color')
            ->toArray();
    }

    public function getAvailableSizesAttribute(): array
    {
        return $this->variants()
            ->where('is_active', true)
            ->whereNotNull('size')
            ->distinct()
            ->pluck('size')
            ->toArray();
    }

    public function isInStock(): bool
    {
        if ($this->variants()->exists()) {
            return $this->variants()->where('is_active', true)->where('stock', '>', 0)->exists();
        }
        return $this->stock > 0;
    }
}
