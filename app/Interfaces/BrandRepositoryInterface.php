<?php
namespace App\Interfaces;


interface BrandRepositoryInterface {
    public function getAllBrands();
    public function showBrand($uuid);
    public function storeBrand($data);
    public function editBrand($uuid,$data);
    public function deleteBrand($uuid);
}