<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
              $table->id();
              $table->unsignedBigInteger('tenant_id');
              $table->string('title');
              $table->longText('content');
              $table->string('featured_image')->nullable();
              $table->unsignedBigInteger('category_id')->nullable();
              $table->unsignedBigInteger('created_by');
              $table->unsignedBigInteger('updated_by')->nullable();
              $table->timestamps();

              $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
              $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
              $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
              $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
