<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    public function myTasks(){
        $tasks = Task::where('created_by',JWTAuth::user()->id)->orWhere('assigned_to',JWTAuth::user()->id)->get();
        return view('tasks.my_tasks',compact('tasks'));
    }

    public function index(){
        $tasks = Task::all();
        $users = User::all();
        return view('tasks.index',compact('tasks','users'));
    }

    public function create(){
        $users = User::where('role',0)->get();
        return view('tasks.create',compact('users'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'assigned_to'=>'nullable|exists:users,id',
            'status'=>'required|integer'
        ]);

        $data['created_by'] = JWTAuth::user()->id;
        Task::create($data);

        return redirect()->route('dashboard');
    }

    public function edit(Task $task){
        $user = JWTAuth::user();
    
        // User biasa hanya bisa edit task yang dibuat sendiri
        if($user->role == 0 && $task->created_by != $user->id){
            abort(403, 'Unauthorized');
        }
    
        $users = $user->role == 1 ? User::where('role',0)->get() : [];
        return view($user->role==1 ? 'tasks.edit' : 'tasks.edit', compact('task','users'));
    }
    
    public function update(Request $request, Task $task){
        $user = JWTAuth::user();
        if($user->role == 0 && $task->created_by != $user->id){
            abort(403, 'Unauthorized');
        }
    
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'assigned_to'=>'nullable|exists:users,id',
            'status'=>'required|integer'
        ]);
    
        $task->update($data);
        return redirect()->route($user->role==1 ? 'tasks.index' : 'tasks.my')->with('success','Task updated');
    }
    
    public function destroy(Task $task){
        $user = JWTAuth::user();
        if($user->role == 0 && $task->created_by != $user->id){
            abort(403,'Unauthorized');
        }
    
        $task->delete();
        return redirect()->back()->with('success','Task deleted');
    }
}
