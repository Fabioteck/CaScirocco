<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->unsignedSmallInteger('size_sqm')->nullable()->after('capacity');
            $table->string('bed_type')->nullable()->after('size_sqm');
            $table->string('bathroom_type')->nullable()->after('bed_type');
            $table->json('amenities')->nullable()->after('images');
        });

        DB::transaction(function () {
            DB::table('rooms')->where('name', 'Scirocco')->update([
                'slug' => 'scirocco',
                'capacity' => 2,
                'size_sqm' => 28,
                'bed_type' => 'Letto matrimoniale king size',
                'bathroom_type' => 'Bagno privato con doccia',
                'price_per_night' => 120.00,
                'description' => 'La stanza Scirocco offre un ambiente elegante e silenzioso con tonalita calde, ideale per un soggiorno romantico o di relax.',
                'images' => json_encode(['images/stanze/scirocco.jpg']),
                'amenities' => json_encode(['Wi-Fi', 'Aria condizionata', 'TV', 'Frigobar', 'Asciugacapelli']),
                'updated_at' => now(),
            ]);

            DB::table('rooms')->where('name', 'Grecale')->update([
                'slug' => 'grecale',
                'capacity' => 2,
                'size_sqm' => 24,
                'bed_type' => 'Letto matrimoniale',
                'bathroom_type' => 'Bagno privato',
                'price_per_night' => 95.00,
                'description' => 'Grecale e una camera luminosa dal carattere essenziale, pensata per chi cerca comfort e praticita in un contesto naturale.',
                'images' => json_encode(['images/stanze/grecale.jpg']),
                'amenities' => json_encode(['Wi-Fi', 'Aria condizionata', 'TV', 'Set cortesia']),
                'updated_at' => now(),
            ]);

            DB::table('rooms')->where('name', 'Libeccio')->update([
                'slug' => 'libeccio',
                'capacity' => 3,
                'size_sqm' => 32,
                'bed_type' => 'Matrimoniale + letto singolo',
                'bathroom_type' => 'Bagno privato con doccia ampia',
                'price_per_night' => 110.00,
                'description' => 'Libeccio e la soluzione perfetta per piccole famiglie, con spazi generosi e un atmosfera accogliente.',
                'images' => json_encode(['images/stanze/libeccio.jpg']),
                'amenities' => json_encode(['Wi-Fi', 'Aria condizionata', 'TV', 'Frigobar', 'Bollitore']),
                'updated_at' => now(),
            ]);

            DB::table('rooms')->where('name', 'Tramontana')->update([
                'slug' => 'tramontana',
                'capacity' => 2,
                'size_sqm' => 20,
                'bed_type' => 'Letto matrimoniale',
                'bathroom_type' => 'Bagno privato',
                'price_per_night' => 80.00,
                'description' => 'Tramontana e una camera raccolta e tranquilla, ideale per chi desidera un soggiorno semplice e rigenerante.',
                'images' => json_encode(['images/stanze/tramontana.jpg']),
                'amenities' => json_encode(['Wi-Fi', 'Aria condizionata', 'TV']),
                'updated_at' => now(),
            ]);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'size_sqm', 'bed_type', 'bathroom_type', 'amenities']);
        });
    }
};

