<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Project\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('client')->orderBy('created_at', 'desc')->get();
        return view('project::index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'deadline' => 'nullable|date',
        ]);

        Project::create($request->all());
        return back()->with('success', 'Project berhasil dibuat.');
    }

    public function kanban($id)
    {
        $project = Project::with('tasks.assignee')->findOrFail($id);
        
        // Group tasks by status
        $tasks = [
            'todo' => $project->tasks->where('status', 'todo')->values(),
            'in_progress' => $project->tasks->where('status', 'in_progress')->values(),
            'review' => $project->tasks->where('status', 'review')->values(),
            'done' => $project->tasks->where('status', 'done')->values(),
        ];
        
        $users = DB::table('users')->get();

        return view('project::kanban', compact('project', 'tasks', 'users'));
    }
    
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return redirect()->route('project.index')->with('success', 'Project berhasil dihapus.');
    }
}
