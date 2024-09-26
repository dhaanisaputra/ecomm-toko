<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', HomePage::class);

// crendential login
// user: admintoko@gmail.com
// pass: admintoko1
