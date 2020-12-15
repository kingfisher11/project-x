<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        // query trainings from trainings table using model
        $trainings = \App\Models\Training::all();
        // return to view with $trainings
        //resources/view/trainings/index.blade.php
        return view('trainings.index', compact('trainings'));
    }
}
