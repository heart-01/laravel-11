<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Route using view
Route::get('home', function () {
    return view('welcome');
});

// Route using controller
Route::get('showProfile1', 'App\Http\Controllers\HomeController@showProfile');
Route::get('showProfile2', [HomeController::class, 'showProfile']);

// method: GET
Route::get('/', function() {
    return 'Hello World';
});

Route::get('about', function() {
    return 'My about page';
});

// Route with parameters
Route::get('user/{id}', function($id) {
    return 'User: ' . $id;
});

Route::get('posts/{post}/comments/{comment}', function($postId, $commentId) {
    return 'Post: ' . $postId . '<br>Comment: ' . $commentId;
});

// Optional parameters
Route::get('cat/{name?}', function($name = null) {
    return 'My cat ' . $name;
});

// Regular expression constraints
Route::get('category/{name}', function($name) {
    return 'Category ' . $name;
})->where('name', '[A-Za-z]+');

// Named routes
Route::get('guest/showroom/data/{name}', function($name) {
    return 'Hello ' . $name;
})->name('guestprofile');

// method: POST
Route::post('user/profile', function() {
    return 'POST';
});

// method: PUT
Route::put('user/profile',function(){
    return'PUT';
});

// method: PATCH
Route::patch('user/profile',function(){
    return'PATCH';
});

// method: DELETE
Route::delete('user/profile',function(){
    return'DELETE';
});
