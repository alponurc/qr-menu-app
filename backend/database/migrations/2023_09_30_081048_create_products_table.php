<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->timestamps();

      $table->string('name');
      $table->text('description');
      $table->string('image');
      $table->decimal('price', 10, 2);
      $table->integer('quantity')->nullable();
      $table->integer('weight')->nullable();
      $table->integer('calories')->nullable();
      $table->json('tags')->nullable();
      $table->json('category')->nullable();
      $table->boolean('is_new')->default(false);
      $table->boolean('is_hot')->default(false);
      $table->boolean('is_recommended')->default(false);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('products');
  }
};
