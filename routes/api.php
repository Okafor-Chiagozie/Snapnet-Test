<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
   return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

   Route::apiResource('projects', ProjectController::class);

   Route::apiResource('projects.employees', EmployeeController::class);

   Route::post(
      'projects/{project}/employees/{employee}/restore',
      [EmployeeController::class, 'restore']
   )
      ->name('employees.restore');
});
