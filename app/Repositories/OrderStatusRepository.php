<?php
namespace App\Repositories;

use App\Interfaces\OrderStatusRepositoryInterface;
use App\Models\OrderStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class OrderStatusRepository implements OrderStatusRepositoryInterface
{
    
    public function orderStatuses() 
    {
        $orderStatuses = OrderStatus::all();
        return $orderStatuses;       
    }

    public function getOrderStatus($uuid) : OrderStatus
    {
        $this->checkIfOrderStatusExist($uuid);
        $orderStatus = OrderStatus::where('uuid',$uuid)->first();
        return $orderStatus;
    }

    public function createOrderStatus($data) : OrderStatus
    {
        $title = $data['title'];
        $uuid = Str::uuid();

        $orderStatus = OrderStatus::create([
            'uuid' => $uuid,
            'title' => $title
        ]);

        return $orderStatus;
    }

    public function editOrderStatus($uuid, $data) : void
    {
        $this->checkIfOrderStatusExist($uuid);
        $title = $data['title'];

        OrderStatus::where('uuid',$uuid)->update([
            'title' => $title
        ]);

        return;
    }

    public function deleteOrderStatus($uuid) : void
    {
        $this->checkIfOrderStatusExist($uuid);
        OrderStatus::where('uuid',$uuid)->delete();
        return;
    }

    public function checkIfOrderStatusExist($uuid) : void
    {
        $orderStatus = OrderStatus::where('uuid',$uuid)->first();
        if(!$orderStatus){
            throw new \Exception('Order Status not found', Response::HTTP_NOT_FOUND);
        }

        return;
    }
}