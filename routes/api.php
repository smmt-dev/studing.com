<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);

    /* Course Routes  */
    Route::resource('course', CourseController::class)->except([
        'create', 'edit'
    ]);

    /* Student Routes  */
    Route::resource('student', StudentController::class)->except([
        'create', 'edit'
    ]);
});