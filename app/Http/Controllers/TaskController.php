<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->orderBy('created_at','desc')->get();
        return view('home', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()){
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'is_completed' => 'nullable|boolean',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        try{

            $validated['user_id'] = Auth::id();
            Task::create($validated);
            return redirect()->route('tasks.index');

        }catch(Exception $e){

            return redirect()->route('tasks.index')->with('error', 'There was an error creating the task. Please try again later.');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->route('tasks.index')->with('message', 'Task not found');
        }

        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        try{
            $task->description = $request->input('description');
            $task->is_completed = $request->has('is_completed');

            if ($task->is_completed){
                $task->deadline = null;
            }

            $task->save();

            return redirect()->route('tasks.index');

        }catch(Exception $e){
            return redirect()->route('tasks.index')->with('error', 'There was an error updating the task. Please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task , $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index');
    }

}
