<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('check_in');
            $table->index('check_out');
            $table->index('status');
            $table->index('room_id');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['check_in']);
            $table->dropIndex(['check_out']);
            $table->dropIndex(['status']);
            $table->dropIndex(['room_id']);
        });
    }
}