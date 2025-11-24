<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogJobsheet;
use App\Models\User;
use App\Models\Jobsheet;
use Illuminate\Http\Request;

class LogJobsheetController extends Controller
{
    public function index()
    {
        $items = LogJobsheet::with('user', 'jobsheet')->latest()->get();
        return view('admin.log_jobsheet.index', compact('items'));
    }

    public function create()
    {
        $users = User::all();
        $jobsheets = Jobsheet::all();
        return view('admin.log_jobsheet.create', compact('users', 'jobsheets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jobsheet_id' => 'required|exists:jobsheets,id',
            'link_pdf' => 'required|file|mimes:pdf|max:5120',
            'nilai' => 'nullable|integer',
            'status' => 'required|in:submitted,graded,pending',
        ]);

        // simpan file ke storage
        $filePath = $request->file('link_pdf')->store('log-jobsheets', 'public');

        LogJobsheet::create([
            'user_id' => $request->user_id,
            'jobsheet_id' => $request->jobsheet_id,
            'link_pdf' => $filePath,
            'nilai' => $request->nilai,
            'status' => $request->status,
        ]);

        return redirect()->route('log-jobsheet.index')->with('success', 'Submitted.');
    }


    public function edit($id)
    {
        $logJobsheet = LogJobsheet::findOrFail($id);
        $users = User::all();
        $jobsheets = Jobsheet::all();
        return view('admin.log_jobsheet.edit', compact('logJobsheet', 'users', 'jobsheets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|between:0,100',
        ]);

        $log = LogJobsheet::findOrFail($id);

        $data = $request->all();
        $data['nilai'] = $request->nilai;
        $data['status'] = 'graded'; // Set status to graded on update
        $log->update($data);

        return redirect()->route('admin.log-jobsheet.index')->with('success', 'Updated.');
    }


    public function destroy($id)
    {
        $LogJobsheet = LogJobsheet::findOrFail($id);
        $LogJobsheet->delete();
        return redirect()->route('admin.log-jobsheet.index')->with('success', 'Tugas siswa berhasil di hapus.');
    }
}
