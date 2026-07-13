<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'category_slug' => $request->input('category'),
            'sort' => $request->input('sort'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
        ];

        // Clean up empty filters
        $filters = array_filter($filters, fn($val) => !is_null($val) && $val !== '');

        $products = $this->productService->getProductsWithFilters($filters, 12);
        $categories = $this->categoryRepository->getAll();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'currentFilters' => $filters,
        ]);
    }

    public function show(string $slug)
    {
        $product = $this->productService->getProductBySlug($slug);

        if (!$product) {
            abort(404);
        }

        $relatedProducts = $this->productService->getRelatedProducts($product);

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function byCategory(string $slug, Request $request)
    {
        $category = $this->categoryRepository->findBySlug($slug);

        if (!$category) {
            abort(404);
        }

        $products = $this->productService->getProductsByCategory($slug);

        return view('products.category', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $products = $this->productService->searchProducts($query);

        return view('products.search', [
            'query' => $query,
            'products' => $products,
        ]);
    }
}
