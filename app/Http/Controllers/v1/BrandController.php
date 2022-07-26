<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\brand\StoreBrandRequest;
use App\Http\Requests\brand\UpdateBrandRequest;
use App\Interfaces\BrandRepositoryInterface;
use App\Traits\SendsApiResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    use SendsApiResponse;
    private BrandRepositoryInterface $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    

    public function index()
    {
       $brands = $this->brandRepository->getAllBrands();
       return $this->successResponse($brands);
    }

    public function showBrand(Request $request)
    {
        $uuid = $request->route('uuid');
        $brand = $this->brandRepository->showBrand($uuid);
        return $this->successResponse($brand);
    }

    public function createBrand(StoreBrandRequest $request)
    {
        $data = $request->validated();
        $brand = $this->brandRepository->storeBrand($data);
        return $this->createdResponse($brand, 'Created Successfully');       
    }

    public function editBrand(UpdateBrandRequest $request)
    {
        $uuid = $request->route('uuid');
        $data = $request->validated();
        $this->brandRepository->editBrand($uuid,$data);

        return $this->successResponse([], 'Brand updated successfully');
    }

    public function deleteBrand(Request $request)
    {
        $uuid = $request->route('uuid');
        
        $this->brandRepository->deleteBrand($uuid);

        return $this->successResponse([], 'Brand deleted successfully');
    }
}
