<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Tenant 1
        $tenant1 = Tenant::create([
            'name' => 'Tenant One',
            'subdomain' => 'tenant1',
        ]);

        $user1 = User::create([
            'name' => 'Admin One',
            'email' => 'admin1@tenant.com',
            'password' => bcrypt('12345678'),
            'tenant_id' => $tenant1->id,
        ]);

        $category1 = Category::create([
            'name' => 'News',
            'tenant_id' => $tenant1->id,
        ]);

        Post::create([
            'title' => 'Tenant One Post',
            'content' => 'This is a post by tenant one.',
            'tenant_id' => $tenant1->id,
            'created_by' => $user1->id,
            'category_id' => $category1->id,
        ]);

        // Create Tenant 2
        $tenant2 = Tenant::create([
            'name' => 'Tenant Two',
            'subdomain' => 'tenant2',
        ]);

        $user2 = User::create([
            'name' => 'Admin Two',
            'email' => 'admin2@tenant.com',
            'password' => bcrypt('123456789'),
            'tenant_id' => $tenant2->id,
        ]);

        $category2 = Category::create([
            'name' => 'Tech',
            'tenant_id' => $tenant2->id,
        ]);

        Post::create([
            'title' => 'Tenant Two Post',
            'content' => 'This is a post by tenant two.',
            'tenant_id' => $tenant2->id,
            'created_by' => $user2->id,
            'category_id' => $category2->id,
        ]);
    }
}
