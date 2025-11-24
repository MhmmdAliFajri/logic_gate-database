<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogMateri;
use App\Models\User;
use App\Models\Materi;
use Illuminate\Http\Request;

class LogMateriController extends Controller
{
    public function index()
    {
        $items = LogMateri::with('user', 'materi')->latest()->get();
        return view('admin.log_materi.index', compact('items'));
    }

    public function create()
    {
        $users = User::all();
        $materis = Materi::all();
        return view('admin.log_materi.create', compact('users', 'materis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materi_id' => 'required|exists:materis,id',
        ]);

        LogMateri::create($request->all());
        return redirect()->route('log-materi.index')->with('success', 'Submission added.');
    }

    public function edit($id)
    {
        $LogMateri = LogMateri::findOrFail($LogMateri);
        $users = User::all();
        $materis = Materi::all();
        return view('admin.kumpulkan_materi.edit', compact('LogMateri', 'users', 'materis'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materi_id' => 'required|exists:materis,id',
        ]);
        $LogMateri = LogMateri::findOrFail($id);

        $LogMateri->update($request->all());
        return redirect()->route('kumpulkan-materi.index')->with('success', 'Submission updated.');
    }

    public function destroy($id)
    {
        $LogMateri = LogMateri::findOrFail($id);
        $LogMateri->delete();
        return redirect()->route('kumpulkan-materi.index')->with('success', 'Deleted successfully.');
    }
}