<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    protected $postRepo;
    public function __construct(PostRepositoryInterface $postRepo) {
        $this->postRepo = $postRepo;
    }
  public function index()
{
    try {
        $posts = $this->postRepo->getAll()->map(function($post){
            if($post->featured_image){
                $post->featured_image = asset('storage/'. $post->featured_image);
            }
            return $post;
        });

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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

          if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validatedData['featured_image'] = $path;
        }

        $validatedData['created_by'] = Auth::id();
        $validatedData['tenant_id'] = Auth::user()->tenant_id;
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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        $validated['updated_by'] = Auth::id();

        if ($request->hasFile('featured_image')) {
            $post = $this->postRepo->find($id);

            if (!$post) {
                return apiResponse(false, 'Post not found', [], 404);
            }

            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }

            // Store new image
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        // Update post
        $updated = $this->postRepo->update($id, $validated);

        if (!$updated) {
            return apiResponse(false, 'Post not updated', [], 404);
        }

        return apiResponse(true, 'Post updated successfully', $updated);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return apiResponse(false, 'Validation failed', $e->errors(), 422);
    } catch (\Throwable $e) {
        return apiResponse(false, 'Something went wrong', [
            'error' => $e->getMessage()
        ], 500);
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
