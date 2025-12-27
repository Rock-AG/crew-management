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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 200);
            $table->string('description', 500)->nullable(true);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('team_size', false, true);
            $table->string('contact_name')->nullable(true)->default(null);
            $table->string('contact_email')->nullable(true)->default(null);
            $table->string('contact_phone')->nullable(true)->default(null);
            $table->foreignIdFor(\App\Models\Plan::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('shifts');
    }
};
