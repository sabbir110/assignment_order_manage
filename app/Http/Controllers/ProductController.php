<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        try {
            $products = $this->productRepository->getAllProducts();
            return response()->json($products);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 409);
        }
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        try {
            $product = $this->productRepository->createProduct($validated);
            return response()->json(["message" => "Product Save Successfully Complete", 'product' => $product], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $product = $this->productRepository->updateProduct($id, $validated);
            return response()->json(["message" => "Product Update Successfully Complete", 'product' => $product], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
