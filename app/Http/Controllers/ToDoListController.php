<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;



class ToDoListController extends Controller
{
    public function tasks()
    {
    	$tasks = Task::all();
		return view('tasks.list', ['tasks' => $tasks]);
    }

    public function create(Request $request) //Creating a new task
	{
		if($request->ajax()){   
			$task = new Task;
			$task->name = $request->text;
			$task->status = 1; // created, waiting for complete
			$task->save();
			

			if ($task) {
			return response()->json([
				"success" => true,
				"text"=>$task->name,
				"id"=>$task->id
				]);
			}else{
				return response()->json([
					"success" => false         

				]);
			}          
		}        
	}

	public function delete(Request $request) //deleting a task
	{
		if($request->ajax()){   
			
			$task = Task::find($request->id);
			$task->delete();
			

			if ($task) {
			return response()->json([
				"success" => true,
				"id" => $request->id
			]);
			}else{
				return response()->json([
					"success" => false         

				]);
			}          
		}        
	}

	public function done(Request $request) //Changing the task status to made
	{
		if($request->ajax()){   
						
			$task = Task::find($request->id);
			if ($task->status == 1) {
				$task->status = 2;
			}else{
				$task->status = 1;
			}
			$task->save();

			if ($task) {
			return response()->json([
				"success" => true,
				"id" => $request->id,
				"status" =>$task->status
			]);
			}else{
				return response()->json([
					"success" => false         

				]);
			}          
		}        
	}
}
