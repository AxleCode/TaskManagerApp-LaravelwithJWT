<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{
    public function index(){
        $user = JWTAuth::user();
        $users = null; // default biar tidak error
    
        if($user->role == 0){
            // user
            $tasks = Task::where('created_by',$user->id)
                         ->orWhere('assigned_to',$user->id)
                         ->get();
        } else {
            // admin
            $tasks = Task::all();
            $users = User::all();
        }
    
        // Task stats untuk chart
        $taskStats = Task::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')->pluck('count','status');
    
        return view('dashboard',compact('user','tasks','users','taskStats'));
    }
    
}
