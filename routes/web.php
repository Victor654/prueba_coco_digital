<?php

use App\Http\Livewire\UsersTable;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/users', UsersTable::class)
    ->name('users');

Route::group(['middleware' => [
    'auth:sanctum',
    'verified'
]], function () {
    

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/planes', function () {
        return view('admin.planes');
    })->name('planes');

});