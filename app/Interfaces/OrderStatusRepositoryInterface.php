<?php
namespace App\Interfaces;


interface OrderStatusRepositoryInterface {
    public function orderStatuses();
    public function getOrderStatus($uuid);
    public function createOrderStatus($data);
    public function editOrderStatus($uuid,$data);
    public function deleteOrderStatus($uuid);
}