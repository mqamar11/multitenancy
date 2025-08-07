<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'subdomain'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    
}
