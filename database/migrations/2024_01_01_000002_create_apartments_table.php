<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->decimal('price', 10, 2);
            $table->integer('rooms');
            $table->integer('floor')->nullable();
            $table->integer('total_floors')->nullable();
            $table->integer('area');
            $table->enum('type', ['flat', 'house', 'room', 'studio'])->default('flat');
            $table->enum('status', ['available', 'rented', 'unavailable'])->default('available');
            $table->text('amenities')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};