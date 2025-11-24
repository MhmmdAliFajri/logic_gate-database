<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogJobsheet;
use Illuminate\Support\Facades\Storage;

class LogJobsheetApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jobsheet_id' => 'required|exists:jobsheets,id',
            'file' => 'required|mimes:pdf|max:5120',
        ]);

        $user = Auth::user();

        // Cek apakah sudah pernah mengumpulkan
        $exists = LogJobsheet::where('user_id', $user->id)
            ->where('jobsheet_id', $request->jobsheet_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You have already submitted this jobsheet.'
            ], 409);
        }

        $filePath = $request->file('file')->store('log-jobsheets', 'public');

        LogJobsheet::create([
            'user_id' => $user->id,
            'jobsheet_id' => $request->jobsheet_id,
            'link_pdf' => $filePath,
            'status' => 'submitted'
        ]);

        return response()->json([
            'message' => 'Jobsheet submitted successfully.',
            'file_path' => $filePath
        ], 201);
    }
}
