<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use File;
use Storage;

class TrainingController extends Controller
{
    public function index()
    {
        // query trainings from trainings table using model
        $trainings = \App\Models\Training::paginate();
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

        if ($request->hasFile('attachment')){
            // rename file 10-2020-12-22.jpg
            $filename = $training->id.'-'.date("Y-m-d").'.'.$request->attachment->getClientOriginalExtension();
            // store file on storage
            Storage::disk('public')->put($filename, File::get($request->attachment));
            // update row with filename
            $training->update(['attachment'=>$filename]);
        }
        // return to index
        return redirect()->back();
    }

    public function show(Training $training)
    {
        // find id on table using model
        //$training = Training::find($id);
        // this function is using Binding Model

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

    public function update($id, Request $request)
    {
        // find id at tables
        $training = Training::find($id);

        // update training with edited attributes
        // method 2 - mass assignment
        $training->update($request->only('title', 'description', 'trainier'));

        // return to trainings
        return redirect()->route('training:list');
    }

    public function delete(Training $training)
    {
        // find id on table using model
        //$training = Training::find($id);
        // this function is using Binding Model
        if ($training->attachment != null){
            Storage::disk('public')->delete($training->attachment);
        }
        $training->delete();

        // return to view
        return redirect()->route('training:list');
    }
}
