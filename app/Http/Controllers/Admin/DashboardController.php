<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Add;
use App\Models\Jobsheet;
use App\Models\Materi;
use App\Models\User;
class DashboardController extends Controller
{
    //
    public function index()
    {
        $items = [
            'add' => Add::count(),
            'jobsheet' => Jobsheet::count(),
            'materi' => Materi::count(),
            'user' => User::where('role',  'user')->count(),
        ];
        return view('admin.dashboard', compact('items'));
    }
}
