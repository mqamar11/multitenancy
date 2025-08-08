<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'content', 'category_id', 'tenant_id', 'featured_image', 'created_by', 'updated_by'
    ];

     public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

      public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

      public function editor() {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
