<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Banner;

class HomeController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function index()
    {
        $products = $this->productService->getHomePageProducts();
        $categories = $this->categoryRepository->getActive();
        $heroBanners = Banner::active()->byPosition('hero')->get();
        $promoBanners = Banner::active()->byPosition('promo')->get();

        return view('home', [
            'categories' => $categories,
            'featuredProducts' => $products['featured'],
            'bestSellers' => $products['bestSellers'],
            'heroBanners' => $heroBanners,
            'promoBanners' => $promoBanners,
        ]);
    }
}
