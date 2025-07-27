<?php
use App\Models\Tenant;
use App\Models\Post;
class PostRepository implements PostRepositoryInterface {

    protected $tenant;

    public function __construct() {
        $this->tenant = app(Tenant::class);
    }

    public function getAll() {
        return Post::where('tenant_id', $this->tenant->id)->get();
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
