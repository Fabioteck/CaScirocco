<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
{
    Schema::table('table_bookings', function (Blueprint $table) {
        // Controlliamo se la colonna esiste già prima di aggiungerla
        if (!Schema::hasColumn('table_bookings', 'table_id')) {
            $table->foreignId('table_id')->nullable()->constrained('tables');
        }
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_bookings', function (Blueprint $table) {
            //
        });
    }
};
