<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Add;
use Illuminate\Http\Request;

class AddApiController extends Controller
{
    public function index()
    {
        $adds = Add::all();

        return response()->json([
            'message' => 'List data Add.',
            'data' => $adds
        ],200);
    }
}