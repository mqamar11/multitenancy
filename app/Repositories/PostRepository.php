<?php
namespace App\Repositories;

use App\Models\Tenant;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;
class PostRepository implements PostRepositoryInterface {

    protected $tenant;

    public function __construct() {
        $this->tenant = app(Tenant::class);
    }

    public function getAll() {
        // $tenantId = Auth::user()->tenant_id;
        $posts =  Post::with(['category:id,name', 'creator:id,name', 'editor:id,name'])
        ->where('tenant_id',  1)
        ->orderByDesc('created_at')
        ->orderByDesc('created_by')
        ->orderByDesc('updated_at')
        ->orderByDesc('updated_by')
        ->get();

        return $posts;
    }

    public function find($id) {
        return Post::where('id', $this->tenant->id)->firstOrFail($id);
    }

    public function create(array $data) {
        $data['tenant_id'] = $this->tenant->id;
        return Post::create($data);
    }

     public function update($id, array $data) {
        $post = $this->find($id);
        $post->update($data);
        return $post;
    }

    public function delete($id) {
        $post = $this->find($id);
        return $post->delete();
    }
}
