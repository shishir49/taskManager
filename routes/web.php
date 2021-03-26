<?php

use Illuminate\Support\Facades\Route;

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

Route::get('','App\Http\Controllers\Master@index');

Route::post('sortTasks','App\Http\Controllers\Master@sort');

Route::get('getTasks','App\Http\Controllers\Master@getTasks');

Route::post('addTask','App\Http\Controllers\Master@addTask');

Route::get('deleteTaskModal/{id}','App\Http\Controllers\Master@deleteTaskModal');

Route::post('deleteTask/{id}','App\Http\Controllers\Master@deleteTask');

Route::post('addProject','App\Http\Controllers\Master@addProject');

Route::get('editTaskModal/{id}','App\Http\Controllers\Master@taskEditData');

Route::post('editTask/{id}','App\Http\Controllers\Master@editTask');


