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
        Schema::create('table_bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('table_id')->constrained();
            $table->string('customer_name');
            $table->date('booking_date');
            $table->enum('slot', ['pranzo', 'cena']);
            $table->integer('people_count');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_bookings');
    }
};
