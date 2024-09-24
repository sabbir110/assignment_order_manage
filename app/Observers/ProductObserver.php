<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $cachedProducts = Cache::get("all_products");
        if ($cachedProducts) {
            $cachedProducts->prepend($product);
            Cache::put("all_products", $cachedProducts, 60);
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $cachedProducts = Cache::get("all_products");
        if ($cachedProducts) {
            $index = $cachedProducts->search(function ($item) use ($product) {
                return $item->id == $product->id;
            });

            if ($index !== false) {
                $cachedProducts[$index] = $product;

                Cache::put("all_products", $cachedProducts, 60);
            }
        }
    }

 
}
