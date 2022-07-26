<?php
namespace App\Repositories;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BrandRepository implements BrandRepositoryInterface
{
    
    public function getAllBrands() 
    {
        $brands = Brand::all();
        return $brands;       
    }

    public function showBrand($uuid) : Brand
    {
        $this->checkIfBrandExist($uuid);
        $brand = Brand::where('uuid',$uuid)->first();
        return $brand;
    }

    public function storeBrand($data) : Brand
    {
        $title = $data['title'];
        $uuid = Str::uuid();
        $slug = Str::slug($title);

        $brand = Brand::create([
            'uuid' => $uuid,
            'title' => $title,
            'slug' => $slug
        ]);

        return $brand;
    }

    public function editBrand($uuid, $data) : void
    {
        $this->checkIfBrandExist($uuid);
        $title = $data['title'];
        $slug = Str::slug($title);

        Brand::where('uuid',$uuid)->update([
            'title' => $title,
            'slug' => $slug
        ]);

        return;
    }

    public function deleteBrand($uuid) : void
    {
        $this->checkIfBrandExist($uuid);
        Brand::where('uuid',$uuid)->delete();
        return;
    }

    public function checkIfBrandExist($uuid) : void
    {
        $brand = Brand::where('uuid',$uuid)->first();
        if(!$brand){
            throw new \Exception('Brand not found', Response::HTTP_NOT_FOUND);
        }

        return;
    }
}