import Alpine from 'alpinejs';
import { toggleWishlist, updateCartItem, removeCartItem, productDetail } from './api';

window.toggleWishlist = toggleWishlist;
window.updateCartItem = updateCartItem;
window.removeCartItem = removeCartItem;


// Axios defaults for AJAX requests
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF token for AJAX
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
}

// Cart count helper
window.updateCartCount = function (count) {
    const badges = document.querySelectorAll('[data-cart-count]');
    badges.forEach(badge => {
        badge.textContent = count;
        badge.classList.toggle('hidden', count === 0);
    });
};

// Toast notification
window.showToast = function (message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-modal text-sm font-medium animate-slide-down ${
        type === 'success' ? 'bg-primary text-white' : 'bg-red-500 text-white'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

// Format currency to IDR
window.formatCurrency = function (amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
};

window.Alpine = Alpine;
Alpine.data('productDetail', productDetail);
Alpine.start();
