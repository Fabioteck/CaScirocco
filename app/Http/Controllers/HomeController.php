<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Room;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::query()->get();
        $galleries = Gallery::query()->orderBy('sort_order')->get();
        $settings = Setting::query()->pluck('value', 'key');

        return view('welcome', compact('rooms', 'galleries', 'settings'));
    }
}

