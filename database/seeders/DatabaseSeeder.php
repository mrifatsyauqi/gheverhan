<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Banner;
use App\Models\StoreSetting;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────
        $admin = User::create([
            'name' => 'Admin GHEVERHAN',
            'email' => 'admin@gheverhan.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $customer = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'customer@gheverhan.com',
            'password' => Hash::make('password'),
            'phone' => '081298765432',
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // ── Addresses ──────────────────────────────────────
        Address::create([
            'user_id' => $customer->id,
            'label' => 'Rumah',
            'recipient_name' => 'Ahmad Rizki',
            'phone' => '081298765432',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'postal_code' => '12110',
            'full_address' => 'Jl. Senopati No. 88, RT 05/RW 02',
            'is_default' => true,
        ]);

        Address::create([
            'user_id' => $customer->id,
            'label' => 'Kantor',
            'recipient_name' => 'Ahmad Rizki',
            'phone' => '081298765432',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Pusat',
            'district' => 'Menteng',
            'postal_code' => '10310',
            'full_address' => 'Jl. Thamrin No. 10, Gedung Menara Utama Lt. 15',
            'is_default' => false,
        ]);

        // ── Categories ─────────────────────────────────────
        $categories = [
            ['name' => 'T-Shirts', 'slug' => 't-shirts', 'description' => 'Koleksi kaos premium', 'sort_order' => 1, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80'],
            ['name' => 'Hoodies', 'slug' => 'hoodies', 'description' => 'Hoodie hangat dan stylish', 'sort_order' => 2, 'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600&q=80'],
            ['name' => 'Pants', 'slug' => 'pants', 'description' => 'Celana casual dan formal', 'sort_order' => 3, 'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600&q=80'],
            ['name' => 'Shoes', 'slug' => 'shoes', 'description' => 'Sepatu untuk setiap gaya', 'sort_order' => 4, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Aksesoris pelengkap gaya', 'sort_order' => 5, 'image' => 'https://images.unsplash.com/photo-1523206489230-c012c64b2b48?w=600&q=80'],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'description' => 'Jaket dan outer stylish', 'sort_order' => 6, 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&q=80'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ── Products ───────────────────────────────────────
        $products = [
            // T-Shirts
            [
                'category' => 't-shirts', 'name' => 'Essential Oversized Tee', 'price' => 249000, 'compare_price' => 329000,
                'description' => 'Kaos oversized premium dengan bahan cotton combed 30s. Nyaman untuk daily wear dengan cutting modern yang mengikuti tren streetwear terkini.',
                'weight' => 250, 'stock' => 100, 'rating' => 4.8, 'rating_count' => 124, 'is_featured' => true,
                'colors' => ['#111111', '#FFFFFF', '#808080'], 'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&q=80'
            ],
            [
                'category' => 't-shirts', 'name' => 'Minimalist Logo Tee', 'price' => 199000, 'compare_price' => null,
                'description' => 'Kaos dengan logo GHEVERHAN minimalis. Bahan premium cotton yang adem dan tidak mudah kusut.',
                'weight' => 220, 'stock' => 80, 'rating' => 4.5, 'rating_count' => 89, 'is_featured' => false,
                'colors' => ['#111111', '#FFFFFF'], 'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800&q=80'
            ],
            [
                'category' => 't-shirts', 'name' => 'Graphic Art Tee - Wave', 'price' => 279000, 'compare_price' => 349000,
                'description' => 'Kaos dengan graphic print eksklusif. Desain limited edition dengan teknik sablon DTF berkualitas tinggi.',
                'weight' => 260, 'stock' => 50, 'rating' => 4.7, 'rating_count' => 67, 'is_featured' => true,
                'colors' => ['#111111', '#1a1a2e'], 'sizes' => ['M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&q=80'
            ],
            [
                'category' => 't-shirts', 'name' => 'Premium Basic Crew Neck', 'price' => 179000, 'compare_price' => null,
                'description' => 'Kaos basic crew neck premium. Cocok untuk layering atau dipakai sendiri.',
                'weight' => 200, 'stock' => 150, 'rating' => 4.3, 'rating_count' => 203, 'is_featured' => false,
                'colors' => ['#111111', '#FFFFFF', '#808080', '#2c3e50'], 'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80'
            ],

            // Hoodies
            [
                'category' => 'hoodies', 'name' => 'Classic Pullover Hoodie', 'price' => 449000, 'compare_price' => 549000,
                'description' => 'Hoodie pullover klasik dengan bahan fleece premium. Kangaroo pocket dan drawstring hood.',
                'weight' => 500, 'stock' => 60, 'rating' => 4.9, 'rating_count' => 156, 'is_featured' => true,
                'colors' => ['#111111', '#808080', '#2c3e50'], 'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80'
            ],
            [
                'category' => 'hoodies', 'name' => 'Zip-Up Essential Hoodie', 'price' => 479000, 'compare_price' => null,
                'description' => 'Hoodie zip-up dengan resleting YKK premium. Bahan fleece tebal namun tetap breathable.',
                'weight' => 550, 'stock' => 45, 'rating' => 4.6, 'rating_count' => 78, 'is_featured' => false,
                'colors' => ['#111111', '#FFFFFF'], 'sizes' => ['M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800&q=80'
            ],

            // Pants
            [
                'category' => 'pants', 'name' => 'Relaxed Chino Pants', 'price' => 389000, 'compare_price' => 459000,
                'description' => 'Celana chino dengan potongan relaxed fit. Bahan twill cotton yang nyaman dan tahan lama.',
                'weight' => 400, 'stock' => 70, 'rating' => 4.4, 'rating_count' => 92, 'is_featured' => true,
                'colors' => ['#111111', '#8B7355', '#D2B48C'], 'sizes' => ['28', '30', '32', '34', '36'],
                'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=800&q=80'
            ],
            [
                'category' => 'pants', 'name' => 'Cargo Wide Pants', 'price' => 429000, 'compare_price' => null,
                'description' => 'Celana cargo wide leg dengan multiple pocket. Statement piece untuk streetwear look.',
                'weight' => 450, 'stock' => 55, 'rating' => 4.7, 'rating_count' => 48, 'is_featured' => false,
                'colors' => ['#111111', '#556B2F'], 'sizes' => ['28', '30', '32', '34'],
                'image' => 'https://images.unsplash.com/photo-1517438476312-10d79c077509?w=800&q=80'
            ],

            // Shoes
            [
                'category' => 'shoes', 'name' => 'Urban Runner Sneakers', 'price' => 599000, 'compare_price' => 749000,
                'description' => 'Sneakers casual dengan sol rubber anti-slip. Desain minimalis cocok untuk aktivitas sehari-hari.',
                'weight' => 700, 'stock' => 40, 'rating' => 4.5, 'rating_count' => 67, 'is_featured' => true,
                'colors' => ['#111111', '#FFFFFF'], 'sizes' => ['39', '40', '41', '42', '43', '44'],
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80'
            ],

            // Accessories
            [
                'category' => 'accessories', 'name' => 'Canvas Tote Bag', 'price' => 149000, 'compare_price' => 199000,
                'description' => 'Tote bag canvas tebal dengan desain minimalis. Cocok untuk daily use dan shopping.',
                'weight' => 300, 'stock' => 100, 'rating' => 4.6, 'rating_count' => 134, 'is_featured' => false,
                'colors' => ['#111111', '#FFFFFF'], 'sizes' => [],
                'image' => 'https://images.unsplash.com/photo-1523206489230-c012c64b2b48?w=800&q=80'
            ],
            [
                'category' => 'accessories', 'name' => 'Leather Belt Classic', 'price' => 189000, 'compare_price' => null,
                'description' => 'Ikat pinggang kulit sintetis premium dengan buckle metal berwarna hitam.',
                'weight' => 150, 'stock' => 80, 'rating' => 4.3, 'rating_count' => 45, 'is_featured' => false,
                'colors' => ['#111111', '#8B4513'], 'sizes' => [],
                'image' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?w=800&q=80'
            ],

            // Outerwear
            [
                'category' => 'outerwear', 'name' => 'Bomber Jacket Essential', 'price' => 549000, 'compare_price' => 699000,
                'description' => 'Bomber jacket dengan bahan parasut premium. Water-resistant dan memiliki inner lining yang nyaman.',
                'weight' => 600, 'stock' => 35, 'rating' => 4.8, 'rating_count' => 89, 'is_featured' => true,
                'colors' => ['#111111', '#2c3e50'], 'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&q=80'
            ],
            [
                'category' => 'outerwear', 'name' => 'Denim Trucker Jacket', 'price' => 499000, 'compare_price' => null,
                'description' => 'Jaket denim klasik dengan wash effect. Timeless piece yang wajib ada di lemari pakaian.',
                'weight' => 650, 'stock' => 30, 'rating' => 4.5, 'rating_count' => 56, 'is_featured' => false,
                'colors' => ['#4169E1', '#111111'], 'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1578932750294-f5075e85f44a?w=800&q=80'
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category'])->first();
            $slug = Str::slug($productData['name']);

            $product = Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => $slug,
                'description' => $productData['description'],
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'sku' => strtoupper(Str::random(8)),
                'stock' => $productData['stock'],
                'weight' => $productData['weight'],
                'images' => [
                    $productData['image'],
                    "https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80",
                    "https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=800&q=80",
                ],
                'rating' => $productData['rating'],
                'rating_count' => $productData['rating_count'],
                'is_active' => true,
                'is_featured' => $productData['is_featured'],
            ]);

            // Create variants
            $colors = $productData['colors'];
            $sizes = $productData['sizes'];

            if (!empty($colors) && !empty($sizes)) {
                foreach ($colors as $color) {
                    foreach ($sizes as $size) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'name' => $color . ' / ' . $size,
                            'color' => $color,
                            'size' => $size,
                            'price_adjustment' => 0,
                            'stock' => rand(5, 30),
                            'sku' => strtoupper(Str::random(10)),
                            'is_active' => true,
                        ]);
                    }
                }
            } elseif (!empty($colors)) {
                foreach ($colors as $color) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $color,
                        'color' => $color,
                        'size' => null,
                        'price_adjustment' => 0,
                        'stock' => rand(10, 40),
                        'sku' => strtoupper(Str::random(10)),
                        'is_active' => true,
                    ]);
                }
            }
        }

        // ── Store Settings ─────────────────────────────────
        $settings = [
            ['key' => 'store_name', 'value' => 'GHEVERHAN', 'group' => 'general'],
            ['key' => 'store_description', 'value' => 'Premium streetwear brand for modern youth.', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'hello@gheverhan.com', 'group' => 'general'],
            ['key' => 'contact_whatsapp', 'value' => '6281234567890', 'group' => 'general'],
            ['key' => 'store_logo', 'value' => 'https://ui-avatars.com/api/?name=G&color=ffffff&background=111111', 'group' => 'appearance'],
            ['key' => 'announcement_bar_active', 'value' => '1', 'group' => 'appearance'],
            ['key' => 'announcement_bar_text', 'value' => 'Gratis Ongkir Seluruh Indonesia! Gunakan kode: FREESHIP', 'group' => 'appearance'],
        ];

        foreach ($settings as $set) {
            StoreSetting::create($set);
        }

        // ── Banners ────────────────────────────────────────
        Banner::create([
            'title' => 'Gheverhan Collection',
            'subtitle' => 'Elegan. Nyaman. Untuk Setiap Momen',
            'image' => '/images/demo/hero-1.png', // The user's banner will go here
            'link_url' => '/products',
            'position' => 'hero',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Casual Series',
            'subtitle' => 'Tampil stylish setiap hari',
            'image' => 'https://images.unsplash.com/photo-1540221652346-e5dd6b50f3e7?w=1920&q=80',
            'link_url' => '/category/t-shirts',
            'position' => 'hero',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // ── Shipping Methods ───────────────────────────────
        ShippingMethod::create(['name' => 'JNE Reguler', 'code' => 'jne_reg', 'base_cost' => 15000, 'estimated_days' => '2-3 Hari', 'is_active' => true, 'sort_order' => 1]);
        ShippingMethod::create(['name' => 'J&T Express', 'code' => 'jnt_ez', 'base_cost' => 16000, 'estimated_days' => '2-3 Hari', 'is_active' => true, 'sort_order' => 2]);
        ShippingMethod::create(['name' => 'SiCepat REG', 'code' => 'sicepat_reg', 'base_cost' => 15000, 'estimated_days' => '1-2 Hari', 'is_active' => true, 'sort_order' => 3]);

        // ── Payment Methods ────────────────────────────────
        PaymentMethod::create([
            'name' => 'Bank BCA',
            'code' => 'bca_transfer',
            'type' => 'bank_transfer',
            'account_number' => '1234567890',
            'account_name' => 'PT GHEVERHAN INDONESIA',
            'instructions' => 'Transfer tepat sesuai nominal hingga 3 digit terakhir.',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        PaymentMethod::create([
            'name' => 'Bank Mandiri',
            'code' => 'mandiri_transfer',
            'type' => 'bank_transfer',
            'account_number' => '0987654321',
            'account_name' => 'PT GHEVERHAN INDONESIA',
            'instructions' => 'Transfer tepat sesuai nominal hingga 3 digit terakhir.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        PaymentMethod::create([
            'name' => 'GoPay',
            'code' => 'gopay',
            'type' => 'e_wallet',
            'account_number' => '081234567890',
            'account_name' => 'Gheverhan',
            'is_active' => true,
            'sort_order' => 3,
        ]);
        PaymentMethod::create([
            'name' => 'Bayar di Tempat (COD)',
            'code' => 'cod',
            'type' => 'cod',
            'instructions' => 'Siapkan uang pas saat kurir datang.',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // ── Sample Orders ──────────────────────────────────
        $sampleProduct = Product::first();
        $sampleAddress = Address::where('user_id', $customer->id)->first();

        $order = Order::create([
            'user_id' => $customer->id,
            'address_id' => $sampleAddress->id,
            'order_number' => 'GHV-20240101-A1B2C',
            'status' => 'shipped',
            'subtotal' => 698000,
            'shipping_cost' => 15000,
            'discount' => 0,
            'total' => 713000,
            'shipping_method' => 'jne',
            'tracking_number' => 'JNE1234567890',
            'payment_method' => 'bank_transfer',
            'payment_status' => 'paid',
            'shipping_address_snapshot' => $sampleAddress->formatted_address,
            'paid_at' => now()->subDays(3),
            'shipped_at' => now()->subDays(1),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $sampleProduct->id,
            'product_name' => $sampleProduct->name,
            'product_image' => $sampleProduct->primary_image,
            'quantity' => 2,
            'price' => 249000,
            'subtotal' => 498000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => Product::skip(4)->first()->id ?? $sampleProduct->id,
            'product_name' => Product::skip(4)->first()->name ?? $sampleProduct->name,
            'product_image' => Product::skip(4)->first()->primary_image ?? $sampleProduct->primary_image,
            'quantity' => 1,
            'price' => 200000,
            'subtotal' => 200000,
        ]);

        // Status history
        $statuses = [
            ['status' => 'pending', 'description' => 'Pesanan berhasil dibuat', 'changed_at' => now()->subDays(4)],
            ['status' => 'confirmed', 'description' => 'Pembayaran dikonfirmasi', 'changed_at' => now()->subDays(3)],
            ['status' => 'processing', 'description' => 'Pesanan sedang dikemas', 'changed_at' => now()->subDays(2)],
            ['status' => 'shipped', 'description' => 'Pesanan dikirim via JNE - Resi: JNE1234567890', 'changed_at' => now()->subDays(1)],
        ];

        foreach ($statuses as $status) {
            OrderStatusHistory::create(array_merge($status, ['order_id' => $order->id]));
        }
    }
}
