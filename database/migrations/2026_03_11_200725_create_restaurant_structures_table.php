<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    if (!Schema::hasTable('dining_areas')) {
        Schema::create('dining_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->timestamps();
        });
    }

    if (!Schema::hasTable('tables')) {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number');
            $table->integer('min_capacity')->default(2);
            $table->integer('max_capacity')->default(4);
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_structures');
    }
};
