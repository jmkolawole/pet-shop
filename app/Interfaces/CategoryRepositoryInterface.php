<?php
namespace App\Interfaces;


interface CategoryRepositoryInterface {
    public function getAllCategories();
    public function showCategory($uuid);
    public function storeCategory($data);
    public function editCategory($uuid,$data);
    public function deleteCategory($uuid);
}