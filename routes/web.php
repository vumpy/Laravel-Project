<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/edit/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->name('edit_item');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::post('/admin/add_item', [App\Http\Controllers\AdminController::class, 'add'])->name('add_item');

Route::post('/admin/save', [App\Http\Controllers\AdminController::class, 'save'])->name('save_item');

Route::post('/admin/edit/{id}/save', [App\Http\Controllers\AdminController::class, 'save_edit'])->name('save_edit_item');

Route::get('/admin/delete/{id}', [App\Http\Controllers\AdminController::class, 'delete'])->name('delete');

//Route::get('/admin/edit/{id}',[AdminController::class,"edit"]);
    
