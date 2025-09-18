<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Services\ContentfulService;

Route::get('/', function () {
    return Inertia::render('Index');
})->name('home');

Route::get('/api/places', function () {
    return response()->json([
        'items' => (new ContentfulService())->getPlaces()
    ]);
});
