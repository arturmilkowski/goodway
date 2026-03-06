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
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->string('intro')->nullable();
            $table->text('content')->nullable();
            $table->string('img')->nullable();
            $table->string('img1')->nullable();
            $table->string('site_description')->nullable();
            $table->string('site_keyword')->nullable();
            $table->boolean('approved')->default(1)->index();
            $table->boolean('published')->default(1)->index();
            $table->timestamps();
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
