<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $items = Materi::latest()->get();
        return view('admin.materi.index', compact('items'));
    }

    public function create()
    {
        return view('admin.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|string',
            'konten' => 'required|string',
            'link_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('link_pdf')) {
            $filePath = $request->file('link_pdf')->store('materis', 'public');
        } else {
            $filePath = null; // Handle case where no file is uploaded
        }


        Materi::create([
            'title' => $request->title,
            'duration' => $request->duration,
            'konten' => $request->konten,
            'link_pdf' => $filePath,
        ]);

        return redirect()->route('admin.materi.index')->with('success', 'Materi created successfully.');
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|string',
            'konten' => 'required|string',
            'link_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $materi = Materi::findOrFail($id);
        $data = $request->only(['title', 'duration', 'konten']);

        if ($request->hasFile('link_pdf')) {
            // Hapus file lama jika ada
            if ($materi->link_pdf && Storage::disk('public')->exists($materi->link_pdf)) {
                Storage::disk('public')->delete($materi->link_pdf);
            }

            // Simpan file baru
            $data['link_pdf'] = $request->file('link_pdf')->store('materis', 'public');
        }

        $materi->update($data);

        return redirect()->route('admin.materi.index')->with('success', 'Materi updated successfully.');
    }


    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        if ($materi->link_pdf && Storage::disk('public')->exists($materi->link_pdf)) {
            Storage::disk('public')->delete($materi->link_pdf);
        }
        $materi->delete();
        return redirect()->route('admin.materi.index')->with('success', 'Materi deleted.');
    }
}
