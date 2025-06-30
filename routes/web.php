<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('doctors', [UserController::class, 'doctors']);

// Route::get('doctors/{id}', function($id){ 
//         $doctor = User::with('doctor_profile')->find($id);
//          if (! $doctor) {
//             return abort(404);
//         }
//         return $doctor;
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/doctors/{id}', [UserController::class, 'show_doctor'])->name('doctors.show');

require __DIR__.'/auth.php';
