<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubTaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/tasks', [TaskController::class, 'all']);
Route::get('/task/{id}', [TaskController::class, 'one']);
Route::post('/task',[TaskController::class, 'create']);
Route::put('/task/{id}',[TaskController::class, 'update']);
Route::delete('/task/{id}',[TaskController::class, 'delete']);
Route::get('/sub_tasks/{id}', [SubTaskController::class, 'all']);
Route::post('/sub_task', [SubTaskController::class, 'create']);
Route::post('/sub_task/one', [SubTaskController::class, 'create_one']);
Route::put('/sub_task/{id}', [SubTaskController::class, 'update']);
Route::put('/sub_tasks/all', [SubTaskController::class, 'update_sub_tasks']);
Route::delete('/sub_task/{id}',[SubTaskController::class, 'delete']);
Route::get('/sub_tasks', [SubTaskController::class, 'recents']);
