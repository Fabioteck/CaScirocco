<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // es: "Stanza Tramontana"
        $table->text('description')->nullable();
        $table->integer('capacity')->default(2); // posti letto
        $table->boolean('is_active')->default(true);
            $table->decimal('price_per_night', 10, 2)->default(0);
    $table->json('images')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
