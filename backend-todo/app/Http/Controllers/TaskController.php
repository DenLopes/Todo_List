<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subTask;
use App\Models\Task;

class TaskController extends Controller
{
    public function all()
    {
        return Task::orderBy('created_at', 'DESC')->get();
    }

    public function one($id)
    {
        return Task::find($id);
    }


    public function create(Request $request)
    {
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();
        return redirect()->back()->with('success', 'task created successfully!');
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();
        return redirect()->back()->with('success', 'task updated successfully!');
    }

    public function delete($id)
    {
        $task = Task::find($id);
        $subTasks = subTask::where('task_id', $id)->get();
        foreach ($subTasks as $subTask) {
            $subTask->delete();
        }
        $task->delete();
        return redirect()->back()->with('success', 'Task and its subTasks deleted successfully!');
    }
}
