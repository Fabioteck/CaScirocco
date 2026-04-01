<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use Illuminate\Support\Str;

public function run(): void
{
    $categories = ['Ristorante, 'Alloggi', 'Giardino', 'Museo'];

    foreach ($categories as $cat) {
        Category::updateOrCreate(
            ['slug' => Str::slug($cat)],
            ['name' => $cat]
        );
    }
}
