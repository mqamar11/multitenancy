<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'content', 'category_id', 'tenant_id', 'featured_image', 'created_by', 'updated_by'
    ];

     public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }
}
