<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $authUser = $request->user();

        if ($authUser->role === 'user') {
            $query = Task::with('project');

            if ($request->filled('project_id')) {
                $query->where('project_id', $request->project_id);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $tasks = $query
                ->where('user_id', $authUser->id)
                ->paginate(10);

            $projects = Project::whereIn('id', $tasks->pluck('project_id')->unique()->values())
                ->get();

            // Do not fetch users; only pass tasks and projects to the view
            return view('tasks.index', [
                'tasks' => $tasks,
                'projects' => $projects
            ]);
        } else {
            $query = Task::with(['project', 'user']);

            if ($request->filled('project_id')) {
                $query->where('project_id', $request->project_id);
            }
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $tasks = $query->paginate(10);
            $projects = Project::all();
            $users = User::where('role', 'user')->get();

            return view('tasks.index', compact('tasks', 'projects', 'users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $users = User::where('role', 'user')->get();
        return view('tasks.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
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
    public function edit(Request $request, Task $task)
    {
        $authUser = $request->user();

        if ($authUser->role === 'user') {
            // For role 'user' or guests/unauthorized: only show the task's project and assigned user
            $projects = Project::where('id', $task->project_id)->get();
            $users = User::where('id', $task->user_id)->get();
        } else {
            // For managers/admins: show all projects and users (full edit capabilities)
            $projects = Project::all();
            $users = User::all();
        }

        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function getTasksUpdate(Request $request) {
        $lastUpdatedAt = $request->query('last_updated_at');

        $query = Task::with('project');

        if ($lastUpdatedAt) {
            $query->where('updated_at', '>', $lastUpdatedAt);
        }

        return response()->json([
            'tasks' => $query->get(),
            'last_updated_at' => now()->toDateTimeString(),
        ]);
    }
}
