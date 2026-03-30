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
    Schema::create('daily_dishes', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category'); // Antipasto, Primo, ecc.
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->json('allergens')->nullable(); // Array di allergeni
        $table->json('dietary_tags')->nullable(); // Vegan, GF, ecc.
        $table->boolean('is_out_of_stock')->default(false);
        $table->string('image_path')->nullable();

        // IL PONTE: Relazione con la Carta dei Vini
        // Usiamo nullable perché un piatto potrebbe non avere un vino consigliato specifico
        $table->foreignId('suggested_wine_id')
              ->nullable()
              ->constrained('wines')
              ->onDelete('set null');

        $table->date('menu_date'); // Per gestire i menu di giorni diversi
        $table->boolean('is_active')->default(true);
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_dishes');
    }
};
