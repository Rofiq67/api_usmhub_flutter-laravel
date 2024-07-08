<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UsersRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'username' => $request['username'],
            // 'img_profile' => $fileName,
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'tgl_lahir' => $request['tgl_lahir'],
            'progdi' => $request['progdi'],
            'gender' => $request['gender'],
        ]);

        $token = $user->createToken('usm_hub')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->isUser(),
        ], 201);
    }

    public function loginApi(LoginRequest $request)
    {
        $request->validated();

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('usm_hub')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'role' => $user->isUser(),
            ], 200);
        }

        return response()->json([
            'message' => 'Username atau Password anda salah',
        ], 422);
    }


    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function updateProfile(UsersRequest $request)
    {
        $user = Auth::user(); // Mendapatkan informasi pengguna yang sedang login

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Memperbarui informasi profil pengguna
        $userToUpdate = User::find($user->id); // Mendapatkan objek User berdasarkan id pengguna

        if (!$userToUpdate) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Mengambil data yang divalidasi dari request
        $validatedData = $request->validated();

        // Mengelola gambar profil jika ada
        if ($request->hasFile('img_profile')) {
            // Menghapus gambar profil lama jika ada
            if ($userToUpdate->img_profile) {
                // Hapus gambar profil lama dari penyimpanan
                Storage::delete('public/' . $userToUpdate->img_profile);
            }

            // Simpan gambar profil baru di direktori 'public/photos'
            $imgProfilePath = $request->file('img_profile')->store('photos', 'public');

            // Simpan path relatif dari gambar profil baru ke dalam database
            $validatedData['img_profile'] = $imgProfilePath;
        }

        // Lakukan update pada objek user
        $userToUpdate->update($validatedData);

        // Mengembalikan respons sukses
        return response()->json(['message' => 'Profile updated successfully', 'user' => $userToUpdate]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $userToUpdate = User::find($user->id);

            if (!$userToUpdate) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $userToUpdate->password = Hash::make($request->input('password'));
            $userToUpdate->save();

            return response()->json(['message' => 'Password updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
