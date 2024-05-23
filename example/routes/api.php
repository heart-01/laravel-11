<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

$users = [
    ['id' => 1, 'name' => 'John Doe'],
    ['id' => 2, 'name' => 'Jane Doe'],
    ['id' => 3, 'name' => 'John Smith'],
    ['id' => 4, 'name' => 'Jane Smith'],
];

Route::get('/user', function (Request $request) use ($users) {
    return response()->json($users);
});

Route::post('/user', function (Request $request) use ($users) {
    $user = ['id' => count($users) + 1, 'name' => $request->name];
    $users[] = $user;
    return response()->json($users);
});

Route::put('/user/{id}', function (Request $request, $id) use ($users) {
    $user = collect($users)->firstWhere('id', $id);
    $user['name'] = $request->name;
    $users[$id - 1] = $user;
    return response()->json($users);
});

Route::delete('/user/{id}', function (Request $request, $id) use ($users) {
    $users = collect($users)->reject(function ($user) use ($id) {
        return $user['id'] == $id;
    })->values()->all();
    return response()->json($users);
});
