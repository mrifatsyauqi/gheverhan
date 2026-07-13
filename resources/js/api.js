export function toggleWishlist(productId, button, url, loginUrl, isAuthenticated) {
    if (!isAuthenticated) {
        window.location.href = loginUrl;
        return;
    }
    
    window.axios.post(url, { product_id: productId })
        .then(response => {
            const svg = button.querySelector('svg');
            if (response.data.added) {
                svg.classList.add('fill-red-500', 'text-red-500');
                svg.classList.remove('text-gray-500');
            } else {
                svg.classList.remove('fill-red-500', 'text-red-500');
                svg.classList.add('text-gray-500');
            }
            window.showToast(response.data.message);
        })
        .catch(() => window.showToast('Gagal memperbarui wishlist.', 'error'));
}

export function updateCartItem(itemId, quantity) {
    if (quantity === 0) {
        removeCartItem(itemId);
        return;
    }
    window.axios.patch(`/cart/${itemId}`, { quantity })
        .then(response => {
            if (response.data.success) {
                location.reload();
            }
        })
        .catch(() => window.showToast('Gagal memperbarui keranjang.', 'error'));
}

export function removeCartItem(itemId) {
    window.axios.delete(`/cart/${itemId}`)
        .then(response => {
            if (response.data.success) {
                const el = document.getElementById(`cart-item-${itemId}`);
                if (el) {
                    el.style.transition = 'all 0.3s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateX(20px)';
                    setTimeout(() => location.reload(), 300);
                }
            }
        })
        .catch(() => window.showToast('Gagal menghapus item.', 'error'));
}

export function productDetail(config) {
    return {
        productId: config.productId,
        basePrice: config.price,
        variants: config.variants,
        images: config.images,
        currentImage: config.images[0] || 'https://placehold.co/600x600/F2F2F2/111111?text=No+Image',
        currentImageIndex: 0,
        selectedColor: null,
        selectedSize: null,
        selectedVariant: null,
        quantity: 1,
        currentPrice: config.price,
        hovering: false,
        zoomOpen: false,
        addingToCart: false,

        get canAddToCart() {
            if (this.variants.length === 0) return true;
            return this.selectedVariant !== null;
        },

        selectColor(color) {
            this.selectedColor = color;
            this.updateVariant();
        },

        selectSize(size) {
            this.selectedSize = size;
            this.updateVariant();
        },

        updateVariant() {
            if (this.selectedColor && this.selectedSize) {
                this.selectedVariant = this.variants.find(v =>
                    v.color === this.selectedColor && v.size === this.selectedSize && v.is_active
                );
                if (this.selectedVariant) {
                    this.currentPrice = this.basePrice + this.selectedVariant.price_adjustment;
                }
            } else if (this.selectedColor) {
                this.selectedVariant = this.variants.find(v =>
                    v.color === this.selectedColor && v.is_active && v.stock > 0
                );
            } else if (this.selectedSize) {
                this.selectedVariant = this.variants.find(v =>
                    v.size === this.selectedSize && v.is_active && v.stock > 0
                );
            }
        },

        async addToCart() {
            if (!this.canAddToCart || this.addingToCart) return;
            this.addingToCart = true;

            try {
                const response = await window.axios.post(config.cartAddUrl, {
                    product_id: this.productId,
                    variant_id: this.selectedVariant?.id || null,
                    quantity: this.quantity,
                });

                if (response.data.success) {
                    window.showToast(response.data.message);
                    window.updateCartCount(response.data.cartCount);
                }
            } catch (error) {
                const msg = error.response?.data?.message || 'Gagal menambahkan ke keranjang.';
                window.showToast(msg, 'error');
            } finally {
                this.addingToCart = false;
            }
        },
        
        init() {
            this.updateVariant();
        }
    };
}
