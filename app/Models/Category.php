<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
      protected $fillable = ['name', 'tenant_id'];

        public function posts()
        {
            return $this->hasMany(Post::class);
        }

        public function tenant()
        {
            return $this->belongsTo(Tenant::class, 'tenant_id');
        }

}
