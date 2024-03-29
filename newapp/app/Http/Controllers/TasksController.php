<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks();
        return view('dashboard', compact('tasks'));
    }

    public function add()
    {
    	return view('add');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'date' => 'required',
            // 'time' => 'required',
            'deadline' => 'required'
        ]);
    	$task = new Task();
    	$task->description = $request->description;
        $task->date = $request->date;
        // $task->time = $request->time;
        $task->deadline = $request->deadline;
    	$task->user_id = auth()->user()->id;
    	$task->save();
    	return redirect('/dashboard'); 
    }

    public function edit(Task $task)
    {

    	if (auth()->user()->id == $task->user_id)
        {            
             return view('edit', compact('task'));
        }           
        else {
             return redirect('/dashboard');
         }            	
    }

    public function update(Request $request, Task $task)
    {
    	if(isset($_POST['delete'])) {
    		$task->delete();
    		return redirect('/dashboard');
    	}
    	else
    	{
            $this->validate($request, [
                'description' => 'required',
                'date' => 'required',
                // 'time' => 'required',
                'deadline' => 'required'
            ]);
    		$task->description = $request->description;
            $task->date = $request->date;
            // $task->time = $request->time;
            $task->deadline = $request->deadline;

	    	$task->save();
	    	return redirect('/dashboard'); 
    	}    	
    }

    // public function social(){
    //     $socialShare = Share::page('http://127.0.0.1:8000','todo list')
    //     ->facebook()
    //     ->twitter()->getRawLinks();
    //     // dd($socialShare);
    //     return view('dashboard', compact('socialShare'));
    // }

}
