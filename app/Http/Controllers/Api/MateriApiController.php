<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\LogMateri;
use Illuminate\Support\Facades\Auth;

class MateriApiController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $search = $request->query('search'); // Ambil parameter ?search=...

    // Query pencarian
    $query = Materi::query();
    if ($search) {
        $query->where('title', 'like', '%' . $search . '%');
    }
    $query->orderBy('created_at', 'desc');

    $materis = $query->get()->map(function ($materi) use ($user) {
        $isAccessed = LogMateri::where('materi_id', $materi->id)
                        ->where('user_id', $user->id)
                        ->exists();

        return [
            'id' => $materi->id,
            'title' => $materi->title,
            'duration' => $materi->duration,
            'konten' => $materi->konten,
            'link_pdf' => $materi->link_pdf,
            'accessed' => $isAccessed,
        ];
    });

    return response()->json([
        'message' => 'Materi list retrieved successfully.',
        'data' => $materis
    ]);
}


    public function show($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please login first.'
            ], 401);
        }

        $materi = Materi::findOrFail($id);

        $isAccessed = LogMateri::where('materi_id', $materi->id)
                        ->where('user_id', $user->id)
                        ->exists();

        return response()->json([
            'message' => 'Materi detail retrieved successfully.',
            'data' => [
                'id' => $materi->id,
                'title' => $materi->title,
                'duration' => $materi->duration,
                'konten' => $materi->konten,
                'link_pdf' => $materi->link_pdf,
                'accessed' => $isAccessed
            ]
        ]);
    }

    public function new(){
        $data = Materi::latest()->first();
         return response()->json([
            'message' => 'Materi list retrieved successfully.',
            'materi' => $data->title ?? "Tidak ada",
        ]);
    }

}
