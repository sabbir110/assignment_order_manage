<?php
namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function placeOrder(array $items);
    public function getOrderHistory($userId);
}
