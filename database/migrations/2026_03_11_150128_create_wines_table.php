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
    Schema::create('wines', function (Blueprint $table) {
        $table->id();
        // 1. Identità
        $table->string('name');
        $table->string('producer');
        $table->string('vintage')->default('NV'); // NV = Non Vintage
        $table->string('type'); // Rosso, Bianco, ecc.
        $table->string('classification'); // DOCG, DOC, ecc.
        $table->string('grapes')->nullable();
        $table->decimal('alcohol_pct', 4, 1)->nullable();

        // 2. Origine
        $table->string('country')->default('Italia');
        $table->string('region')->nullable();
        $table->string('sub_zone')->nullable();

        // 3. Logistica
        $table->string('format')->default('750ml');
        $table->decimal('price_bottle', 8, 2);
        $table->decimal('price_glass', 8, 2)->nullable();
        $table->decimal('supplier_cost', 8, 2)->nullable();
        $table->string('sku')->unique()->nullable();
        $table->integer('stock')->default(0);
        $table->boolean('is_available')->default(true);

        // 4. Sommelier & Marketing
        $table->text('tasting_notes')->nullable();
        $table->unsignedTinyInteger('body')->default(3); // Scala 1-5
        $table->json('sensory_profile')->nullable(); // Acidità, Tannino ecc in JSON
        $table->text('storytelling')->nullable();
        $table->string('label_image')->nullable();
        
        // 5. Compliance UE
        $table->json('nutritional_info')->nullable(); 

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wines');
    }
};
