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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('intro')->nullable();
            $table->text('content')->nullable();
            $table->string('img')->nullable();
            $table->string('img1')->nullable();
            $table->string('site_description')->nullable();
            $table->string('site_keyword')->nullable();
            $table->boolean('navbar')->default(1)->index();
            $table->boolean('hide')->default(0)->index();
            $table->unsignedSmallInteger('ordinal')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
