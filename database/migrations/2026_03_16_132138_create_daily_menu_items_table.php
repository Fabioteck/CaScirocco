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
        Schema::create('daily_menu_items', function (Blueprint $table) {
    $table->id();
    // Se peschiamo un piatto esistente
    $table->foreignId('dish_id')->nullable()->constrained('dishes')->onDelete('cascade');
    
    // Se è un piatto "fuori menù" creato al volo solo per oggi
    $table->string('custom_name')->nullable();
    $table->decimal('custom_price', 8, 2)->nullable();
    
    $table->date('menu_date'); // Per storico o programmazione
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_menu_items');
    }
};
