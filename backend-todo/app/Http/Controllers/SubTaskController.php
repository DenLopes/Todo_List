<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subTask;
use App\Models\Task;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class SubTaskController extends Controller
{
    public function all($id)
    {
        return subTask::where('task_id', $id)->orderBy('created_at', 'DESC')->get();
    }

    public function create(Request $request)
    {
        $subtasks = $request->sub_tasks;
        $latestTask = Task::latest()->first();
        $task_id = $latestTask->id;
        foreach($subtasks as $subtask)
        {
            $task = new subTask;
            $task->task_name = $subtask;
            $task->state = false;
            $task->task_id = $task_id;
            $task->save();
        }
        return redirect()->back()->with('success', 'tasks created successfully!');
    }

    public function recents() 
    {
        $subTasks = SubTask::where('state', true)
                           ->orderBy('updated_at', 'desc')
                           ->get();
    
        foreach($subTasks as $subTask){
            $task = Task::find($subTask->task_id);
            $subTask->parent_task_name = $task->title;
        }
        return $subTasks;
    }

    public function update(Request $request, $id)
    {

        $task = subTask::find($id);
        if($task){
            if ($request->task_name)
                {$task->task_name = $request->task_name;
            }else
               { $task->state = !$task->state;}
            $task->save();
            return redirect()->back()->with('success', 'task updated successfully!');
        }
        else{
            return redirect()->back()->with('error', 'task not found!');
        }
    }

    public function update_sub_tasks(Request $request, $id) {
        $subTasks = $request->input('subTasks');
        foreach ($subTasks as $subTask) {
            if (array_key_exists('id', $subTask)) {
                $task = SubTask::find($subTask['id']);
                if ($task) {
                    $task->update($subTask);
                }
            } else {
                $newTask = new SubTask;
                $newTask->task_name = $subTask['task_name'];
                $newTask->state = false;
                $newTask->task_id = $id;
                $newTask->save();
            }
        }
        return response()->json(["message" => "subTasks updated successfully!"], 200);
    }

    public function delete($id)
    {
        $task = subTask::find($id);
        $task->delete();
        return redirect()->back()->with('success', 'task deleted successfully!');
    }
}
