<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobsheet;
use App\Models\LogJobsheet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JobsheetApiController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $jobsheets = Jobsheet::all()->map(function ($jobsheet) use ($userId) {
                $log = LogJobsheet::where('jobsheet_id', $jobsheet->id)
                                ->where('user_id', $userId)
                                ->first();

                return [
                    'id' => $jobsheet->id,
                    'title' => $jobsheet->title,
                    'description' => $jobsheet->description,
                    'duration' => $jobsheet->duration,
                    'jobsheet_link_pdf' => $jobsheet->link_pdf,
                    'status' => $log
                        ? ($log->nilai !== null ? 'Sudah dinilai' : 'Sudah dikumpulkan')
                        : 'Belum dikumpulkan',
                    'nilai' => $log && $log->nilai !== null ? floatval($log->nilai / 10 / 2) : 0.0 + 0.0,
                    'link_pdf' => $log->link_pdf ?? null,
                ];

            });

            return response()->json([
                'message' => 'Jobsheet list with user status.',
                'data' => $jobsheets
            ], 200, [], JSON_PRESERVE_ZERO_FRACTION);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $jobsheet = Jobsheet::findOrFail($id);

            $log = LogJobsheet::where('jobsheet_id', $id)
                            ->where('user_id', $userId)
                            ->first();

            return response()->json([
                'id' => $jobsheet->id,
                'title' => $jobsheet->title,
                'description' => $jobsheet->description,
                'duration' => $jobsheet->duration,
                'jobsheet_link_pdf' => $jobsheet->link_pdf,
                'status' => $log ? ($log->nilai !== null ? 'Sudah dinilai' : 'Sudah dikumpulkan') : 'Belum dikumpulkan',
                'nilai' => $log && $log->nilai !== null ? floatval($log->nilai / 10 / 2) : 0.0 + 0.0,
                'link_pdf' => $log->link_pdf ?? null,
            ],200, [], JSON_PRESERVE_ZERO_FRACTION);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Jobsheet not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
