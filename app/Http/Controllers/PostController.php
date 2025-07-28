<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\Request;
use PostRepository;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    protected $postRepo;
    public function __construct(PostRepositoryInterface $postRepo) {
        $this->postRepo = $postRepo;
    }
  public function index()
{
    try {
        $posts = $this->postRepo->getAll();

        if ($posts->isEmpty()) {
            return apiResponse(false, 'No records found', [], 404);
        }

        return apiResponse(true, 'Posts fetched successfully', $posts);

    } catch (\Throwable $e) {
        return apiResponse(false, 'Something went wrong', ['error' => $e->getMessage()], 500);
    }
}


    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validatedData['created_by'] = Auth::id();
        $post = $this->postRepo->create($validatedData);

        return apiResponse(true, 'Post created successfully', $post);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return apiResponse(false, 'Validation failed', $e->errors(), 422);

    } catch (\Throwable $e) {
        return apiResponse(false, 'Something went wrong', [
            'error' => $e->getMessage()
        ], 500);
    }
}

public function show($id)
{
    try {
        $post = $this->postRepo->find($id);

        if (!$post) {
            return apiResponse(false, 'Post not found', [], 404);
        }

        return apiResponse(true, 'Post fetched successfully', $post);

    } catch (\Throwable $e) {
        return apiResponse(false, 'Something went wrong', ['error' => $e->getMessage()], 500);
    }
}


     public function update(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $validated['updated_by'] = Auth::id();

        $updated = $this->postRepo->update($id, $validated);

        if (!$updated) {
            return apiResponse(false, 'Post not found or not updated', [], 404);
        }

        return apiResponse(true, 'Post updated successfully', $updated);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return apiResponse(false, 'Validation failed', $e->errors(), 422);
    } catch (\Throwable $e) {
        return apiResponse(false, 'Something went wrong', ['error' => $e->getMessage()], 500);
    }
}


    public function destroy($id)
{
    try {
        $deleted = $this->postRepo->delete($id);

        if (!$deleted) {
            return apiResponse(false, 'Post not found', [], 404);
        }

        return apiResponse(true, 'Post deleted successfully');

    } catch (\Throwable $e) {
        return apiResponse(false, 'Something went wrong', ['error' => $e->getMessage()], 500);
    }
}



}
