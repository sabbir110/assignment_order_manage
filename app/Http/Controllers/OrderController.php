<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function store(OrderRequest $request)
    {
        $validated = $request->validated();
        $orderItems = $validated['items'];

        try {
            DB::beginTransaction();
            $order = $this->orderRepository->placeOrder($orderItems);
            DB::commit();
          
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return response()->json(['success' => "Order Successfully Complete", 'order' => $order], 200);
    }

    public function index($id = "")
    {
        try {
            $data = $this->orderRepository->getOrderHistory($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
