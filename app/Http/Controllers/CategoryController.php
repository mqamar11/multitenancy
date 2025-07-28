<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }


    public function index()
    {
        try {
            $categories = $this->categoryRepo->all();

            if ($categories->isEmpty()) {
                return apiResponse(false, 'No categories found', null, 404);
            }

            return apiResponse(true, 'Categories fetched successfully', $categories);
        } catch (Exception $e) {
            return apiResponse(false, 'Something went wrong', null, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $validated['created_by'] = Auth::id();

            $category = $this->categoryRepo->create($validated);

            return apiResponse(true, 'Category created successfully', $category, 201);
        } catch (ValidationException $e) {
            return apiResponse(false, 'Validation failed', $e->errors(), 422);
        } catch (Exception $e) {
            return apiResponse(false, 'Something went wrong', null, 500);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryRepo->find($id);

            if (!$category) {
                return apiResponse(false, 'Category not found', null, 404);
            }

            return apiResponse(true, 'Category found', $category);
        } catch (Exception $e) {
            return apiResponse(false, 'Something went wrong', null, 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
            ]);

            $validated['updated_by'] = Auth::id();

            $category = $this->categoryRepo->update($id, $validated);

            return apiResponse(true, 'Category updated successfully', $category);
        } catch (ValidationException $e) {
            return apiResponse(false, 'Validation failed', $e->errors(), 422);
        } catch (Exception $e) {
            return apiResponse(false, 'Something went wrong', null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->categoryRepo->delete($id);

            if (!$deleted) {
                return apiResponse(false, 'Category not found or already deleted', null, 404);
            }

            return apiResponse(true, 'Category deleted successfully');
        } catch (Exception $e) {
            return apiResponse(false, 'Something went wrong', null, 500);
        }
    }


}
