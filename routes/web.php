<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Post Routes
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');


Route::post('/upload-image', function (Request $request) {
    if ($request->hasFile('file')) {
        $image = $request->file('file');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);
        return asset('uploads/' . $imageName);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
});