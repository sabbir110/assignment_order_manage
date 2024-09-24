<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        $cacheKey = 'all_products';
        $cacheDuration = 60;
        return Cache::remember($cacheKey, $cacheDuration, function () {
            return Product::orderBy('id', 'desc')->get();
        });
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

   
}
