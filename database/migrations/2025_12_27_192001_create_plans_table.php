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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('edit_id', 40)->unique();
            $table->string('view_id', 40)->unique();
            $table->string('title', 200);
            $table->string('description', 500);
            $table->string('contact', 200)->nullable(true);
            $table->boolean('allow_unsubscribe')->nullable(false)->default(false);
            $table->boolean('allow_subscribe')->nullable(false)->default(false);
            $table->boolean('show_on_homepage')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
