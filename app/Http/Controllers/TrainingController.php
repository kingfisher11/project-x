<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use File;
use Storage;
use App\Http\Requests\StoreTrainingRequest;
use Mail;
use Notification;
use App\Notifications\DeleteTrainingNotification;

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

    public function store(StoreTrainingRequest $request)
    {   
        // $this->validate(
        //     $request, [
        //         'title' => 'required|min:3',
        //         'description' => 'required'
        //     ]
        //     );
        
        
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

        //send email to user
        // Mail::send('email.training-created',[
        //     'title' => $training->title,
        //     'description' => $training->description
        // ], function($message){
        //     $message->to('muhdhanis08@gmail.com');
        //     $message->subject('Training Created using Inline Mail');


        // });

        // send email to user using Mailable class
        // Mail::to('muhdhanis08@gmail.com')->send(new \App\Mail\TrainingCreated($training));
        // buat mailable using job, copy ke SendEmailJob
        dispatch(new \App\Jobs\SendEmailJob($training));
        // return to index
        return redirect()
        ->route('training:list');
    }

    public function show(Training $training)
    {
        $this->authorize('view', $training);
        // find id on table using model
        //$training = Training::find($id);
        // this function is using Binding Model

        // return to view
        return view('trainings.show', compact('training'));
    }

    public function edit($id)
    {
        // $this->authorize('edit', $training);
        // find id on table using model
        $training = Training::find($id);


        // return to view
        return view('trainings.edit', compact('training'));
    }

    public function update($id, Request $request)
    {
        // $this->authorize('update', $training);
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
        $this->authorize('delete', $training);
        $user = auth()->user();
        Notification::send($user, new DeleteTrainingNotification());

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
