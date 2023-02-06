<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;

class DashboardController extends Controller
{
    public  function home() {

        // $user = Auth::user();
        // $users = User::all();

        $users = User::all();

        $projects = Project::all();

        return view("dashboard", compact("users", "projects"));
    }
}
