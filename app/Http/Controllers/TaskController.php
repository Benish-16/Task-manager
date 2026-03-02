<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller
{
   
    public function index()
    {
        $tenantId = Auth::user()->tenant_id; 
        $tasks = Task::where('tenant_id', $tenantId)->with('assignedUser')->get();

        return view('tasks.list', compact('tasks'));
    }
    


    public function create()
    {
       $users = User::where('tenant_id', Auth::user()->tenant_id)
    ->whereHas('roles', function ($query) {
        $query->whereIn('name', ['employee', 'manager']);
    })
    ->get();
        return view('tasks.create', compact('users'));
    }

public function store(Request $request)
{
   
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'assigned_to' => 'required|exists:users,id',
        'status' => 'required|in:pending,in_progress,completed',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date',
    ]);

 
    Task::create([
        'tenant_id' => Auth::user()->tenant_id, 
        'created_by' => Auth::id(),             
        'assigned_to' => $request->assigned_to,
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
        'priority' => $request->priority,
        'due_date' => $request->due_date,
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
}
  
    public function edit(Task $task)
    {
        
   $users = User::where('tenant_id', Auth::user()->tenant_id)
    ->whereHas('roles', function ($query) {
        $query->whereIn('name', ['employee', 'manager']);
    })
    ->get();
        return view('tasks.edit', compact('task', 'users'));
    }

public function update(Request $request, Task $task)
{
    $this->authorizeTenant($task);

    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'assigned_to' => 'required|exists:users,id',
        'status'      => 'required|in:pending,in_progress,completed',
        'priority'    => 'required|in:low,medium,high',
        'due_date'    => 'nullable|date',
    ]);

    $task->update($request->only(
        'title',
        'description',
        'assigned_to',
        'status',
        'priority',
        'due_date'
    ));

    return redirect()
        ->route('tasks.index')
        ->with('success', 'Task updated successfully!');
}
    

  
    private function authorizeTenant(Task $task)
    {
        if ($task->tenant_id !== Auth::user()->tenant_id) {
            abort(403, 'Unauthorized');
        }
    }

public function printTask(Task $task)
{
    
    $pdf = PDF::loadView('tasks.pdf', compact('task'));


    return $pdf->download('task-' . $task->id . '.pdf');
}

public function destroy(Task $task)
{
   

    $task->delete();

    return redirect()->route('tasks.index')
                     ->with('success', 'Task deleted successfully!');
}
}