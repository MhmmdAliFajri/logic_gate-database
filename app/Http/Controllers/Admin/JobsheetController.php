<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jobsheet;
use Illuminate\Http\Request;

class JobsheetController extends Controller
{
    public function index()
    {
        $items = Jobsheet::latest()->get();
        return view('admin.jobsheet.index', compact('items'));
    }

    public function create()
    {
        return view('admin.jobsheet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'link_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'duration']);

        if ($request->hasFile('link_pdf')) {
            $pdfPath = $request->file('link_pdf')->store('pdf_jobsheets', 'public');
            $data['link_pdf'] = $pdfPath;
        }

        Jobsheet::create($data);
        return redirect()->route('admin.jobsheet.index')->with('success', 'Jobsheet created.');
    }


    public function edit(Jobsheet $jobsheet)
    {
        return view('admin.jobsheet.edit', compact('jobsheet'));
    }

    public function update(Request $request, Jobsheet $jobsheet)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'link_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'duration']);

        if ($request->hasFile('link_pdf')) {
            // Hapus file lama jika ada
            if ($jobsheet->link_pdf && \Storage::disk('public')->exists($jobsheet->link_pdf)) {
                \Storage::disk('public')->delete($jobsheet->link_pdf);
            }

            $pdfPath = $request->file('link_pdf')->store('pdf_jobsheets', 'public');
            $data['link_pdf'] = $pdfPath;
        }

        $jobsheet->update($data);
        return redirect()->route('admin.jobsheet.index')->with('success', 'Jobsheet updated.');
    }


    public function destroy(Jobsheet $jobsheet)
    {
        // Hapus file PDF dari storage jika ada
        if ($jobsheet->link_pdf && \Storage::disk('public')->exists($jobsheet->link_pdf)) {
            \Storage::disk('public')->delete($jobsheet->link_pdf);
        }

        // Hapus data dari database
        $jobsheet->delete();

        return redirect()->route('admin.jobsheet.index')->with('success', 'Deleted.');
    }

}
