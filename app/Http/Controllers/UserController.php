<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorProfile;

class UserController extends Controller
{
    public function doctors()
    {
        $doctors = User::where('user_type' , 2) -> get();
        return view('doctors', ['doctors' => $doctors]);
    } 

    public function show_doctor($doctor)
    {
       $doctor = User::with('doctor_profile')->find($doctor);
        if (! $doctor) {
            return abort(404);
        }
        return view('show_doctor', ['doctor' => $doctor]);
    }
}

