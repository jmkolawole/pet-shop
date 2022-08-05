<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\orderStatus\StoreOrderStatusRequest;
use App\Http\Requests\orderStatus\UpdateOrderStatusRequest;
use App\Interfaces\OrderStatusRepositoryInterface;
use App\Traits\SendsApiResponse;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    //
    use SendsApiResponse;
    private OrderStatusRepositoryInterface $orderStatusRepository;

    public function __construct(OrderStatusRepositoryInterface $orderStatusRepository)
    {
        $this->$orderStatusRepository = $orderStatusRepository;
    }

    public function orderStatuses()
    {
        $orderStatuses = $this->orderStatusRepository->orderStatuses();
        return $this->successResponse($orderStatuses);
    }


    public function createOrderStatus(StoreOrderStatusRequest $request)
    {
        $data = $request->validated();
        $orderStatus = $this->orderStatusRepository->createOrderStatus($data);
        return $this->createdResponse($orderStatus, 'Created Successfully');
    }

    public function getOrderStatus(Request $request)
    {
        $uuid = $request->route('uuid');
        $orderStatus = $this->orderStatusRepository->getOrderStatus($uuid);
        return $this->successResponse($orderStatus);
    }

    public function editOrderStatus(UpdateOrderStatusRequest $request)
    {
        $uuid = $request->route('uuid');
        $data = $request->validated();
        $this->orderStatusRepository->editOrderStatus($uuid, $data);
        return $this->successResponse([], 'OrderStatus updated successfully');
    }

    public function deleteOrderStatus(Request $request)
    {
        $uuid = $request->route('uuid');

        $this->orderStatusRepository->deleteOrderStatus($uuid);

        return $this->successResponse([], 'Order Status deleted successfully');
    }
}
