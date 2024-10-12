<?php

use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('students/{id}/sync-subject', function ($id) {
    $subject = [1, 3, 4, 7, 9];
    $student = Student::find($id);
    $student->subjects()->sync($subject);
    $student->load('subjects');
    dd($student->load('subjects')->toArray());
});
Route::resource('students', StudentController::class);
Route::delete('students/{student}/forceDestroy', [StudentController::class, 'forceDestroy'])
    ->name('students.forceDestroy');
// Route::get('students',[StudentController::class,'index'])->name('students.index');