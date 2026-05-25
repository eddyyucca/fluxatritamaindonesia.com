<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Project\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required',
            'status' => 'required'
        ]);

        $task = Task::create($request->all());
        return back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $task = Task::findOrFail($id);
        $task->status = $request->status;
        
        // Handle sorting if provided
        if ($request->has('order_position')) {
            $task->order_position = $request->order_position;
        }
        
        $task->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function updateOrders(Request $request)
    {
        $tasks = $request->input('tasks'); // array of ['id' => 1, 'status' => 'todo', 'order' => 0]
        
        if (is_array($tasks)) {
            foreach ($tasks as $taskData) {
                Task::where('id', $taskData['id'])->update([
                    'status' => $taskData['status'],
                    'order_position' => $taskData['order']
                ]);
            }
        }
        
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return back()->with('success', 'Tugas berhasil dihapus.');
    }
}
