<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'user' // default sebagai user
            ]);

            return response()->json([
                'message' => 'Register success, please login.',
                'user'    => $user,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }


    public function login(Request $request)
    {
        try {
            // Manual validasi
            $validator = \Validator::make($request->all(), [
                'email'    => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (! $user || ! \Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Login failed',
                    'errors'  => ['email' => ['The provided credentials are incorrect.']],
                ], 422);
            }

            if ($user->role !== 'user') {
                return response()->json([
                    'message' => 'Only user can login from mobile.'
                ], 403);
            }

            $token = $user->createToken('mobile-token')->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'user'    => $user,
                'token'   => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            // ⇢ belum login
            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated. Please login first.'
                ], 401);
            }

            /* ========= 1. VALIDASI ========= */
            $validator = \Validator::make($request->all(), [
                'name'     => 'sometimes|string|max:255',
                'email'    => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:6|confirmed',
                'photo'    => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            /* ========= 2. UPDATE FIELD YANG ADA ========= */
            $data = $validator->validated();

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            /* simpan foto jika ada */
            if ($request->hasFile('photo')) {
                // hapus foto lama (optional)
                if ($user->photo) \Storage::delete('public/' . $user->photo);

                $path = $request->file('photo')
                                ->store('profile', 'public'); // simpan ke storage/app/public/profile
                $data['photo'] = $path;
            }


            $user->fill($data)->save();



            /* ========= 3. RESPONSE ========= */
            return response()->json([
                'message' => 'Profile updated successfully.',
                'user'    => $user   // data terbaru
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function profile(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            return response()->json([
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }




    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
