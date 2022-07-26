<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\category\StoreCategoryRequest;
use App\Http\Requests\category\UpdateCategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Traits\SendsApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use SendsApiResponse;
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    

    public function index()
    {
       $categories = $this->categoryRepository->getAllCategories();
       return $this->successResponse($categories);
    }

    public function showCategory(Request $request)
    {
        $uuid = $request->route('uuid');
        $category = $this->categoryRepository->showCategory($uuid);
        return $this->successResponse($category);
    }

    public function createCategory(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryRepository->storeCategory($data);
        return $this->createdResponse($category, 'Created Successfully');       
    }

    public function editCategory(UpdateCategoryRequest $request)
    {
        $uuid = $request->route('uuid');
        $data = $request->validated();
        $this->categoryRepository->editCategory($uuid,$data);

        return $this->successResponse([], 'Category updated successfully');
    }

    public function deleteCategory(Request $request)
    {
        $uuid = $request->route('uuid');
        
        $this->categoryRepository->deleteCategory($uuid);

        return $this->successResponse([], 'Category deleted successfully');
    }
}
