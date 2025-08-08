<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Post;

class MultiTenancyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
public function test_posts_are_scoped_by_tenant()
{
    // Create tenants
    $foo = Tenant::factory()->create(['subdomain' => 'foo']);
    $bar = Tenant::factory()->create(['subdomain' => 'bar']);

    // Create users for each tenant
    $fooUser = User::factory()->create(['tenant_id' => $foo->id]);
    $barUser = User::factory()->create(['tenant_id' => $bar->id]);

    // Create posts for each tenant
    $fooPost = Post::factory()->create([
        'tenant_id' => $foo->id,
        'created_by' => $fooUser->id,
    ]);

    $barPost = Post::factory()->create([
        'tenant_id' => $bar->id,
        'created_by' => $barUser->id,
    ]);

    // Use the full testing domain
    $domain = config('app.domain') ?? 'tenant.test';

// For foo tenant
$this->actingAs($fooUser)
    ->getJson("http://foo.{$domain}/api/posts/list")
    ->assertStatus(200)
    ->assertJsonFragment(['id' => $fooPost->id])
    ->assertJsonMissing(['id' => $barPost->id]);


// For bar tenant
$this->actingAs($barUser)
    ->getJson("http://bar.{$domain}/api/posts/list")
    ->assertStatus(200)
    ->assertJsonFragment(['id' => $barPost->id])
    ->assertJsonMissing(['id' => $fooPost->id]);

}
}
