<?php
namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    
    public function getAllCategories() 
    {
        $categories = Category::all();
        return $categories;       
    }

    public function showCategory($uuid) : Category
    {
        $this->checkIfCategoryExist($uuid);
        $category = Category::where('uuid',$uuid)->first();
        return $category;
    }

    public function storeCategory($data) : Category
    {
        $title = $data['title'];
        $uuid = Str::uuid();
        $slug = Str::slug($title);

        $category = Category::create([
            'uuid' => $uuid,
            'title' => $title,
            'slug' => $slug
        ]);

        return $category;
    }

    public function editCategory($uuid, $data) : void
    {
        $this->checkIfCategoryExist($uuid);
        $title = $data['title'];
        $slug = Str::slug($title);

        Category::where('uuid',$uuid)->update([
            'title' => $title,
            'slug' => $slug
        ]);

        return;
    }

    public function deleteCategory($uuid) : void
    {
        $this->checkIfCategoryExist($uuid);
        Category::where('uuid',$uuid)->delete();
        return;
    }

    public function checkIfCategoryExist($uuid) : void
    {
        $category = Category::where('uuid',$uuid)->first();
        if(!$category){
            throw new \Exception('Category not found', Response::HTTP_NOT_FOUND);
        }

        return;
    }
}