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
    Schema::table('table_bookings', function (Blueprint $table) {
        // Aggiungiamo la colonna email dopo il nome del cliente
        $table->string('customer_email')->after('customer_name')->nullable();
        // Aggiungiamo anche il telefono che potrebbe servire al ristorante
        $table->string('customer_phone')->after('customer_email')->nullable();
    });
}

public function down(): void
{
    Schema::table('table_bookings', function (Blueprint $table) {
        $table->dropColumn(['customer_email', 'customer_phone']);
    });
}


};
