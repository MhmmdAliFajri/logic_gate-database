<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogMateri;
use Illuminate\Support\Facades\Auth;

class LogMateriApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'materi_id' => 'required|exists:materis,id',
        ]);

        $user = Auth::user();

        // Cek duplikat
        $exists = LogMateri::where('user_id', $user->id)
            ->where('materi_id', $request->materi_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You have already accessed this materi.'
            ], 409); // Conflict
        }

        // Simpan log akses
        LogMateri::create([
            'user_id' => $user->id,
            'materi_id' => $request->materi_id,
        ]);

        return response()->json([
            'message' => 'Log materi saved successfully.'
        ]);
    }
}
