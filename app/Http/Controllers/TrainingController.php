<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;

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

    public function create()
    {
        // return function create form
        // resources/view/training/create.blade.php
        return view('trainings.create');
    }

    public function store(Request $request)
    {
        // store all data from form to training table
        // dd($request->all()); //debug
        // method 1 POPO (plain old php object)
        $training = new Training(); 
        $training->title = $request->title;
        $training->description = $request->description;
        $training->trainer = $request->trainer;
        $training->user_id = auth()->user()->id;
        $training->save();
        // return to index
        return redirect()->back();
    }

    public function show($id)
    {
        // find id on table using model
        $training = Training::find($id);


        // return to view
        return view('trainings.show', compact('training'));
    }

    public function edit($id)
    {
        // find id on table using model
        $training = Training::find($id);


        // return to view
        return view('trainings.edit', compact('training'));
    }
}
