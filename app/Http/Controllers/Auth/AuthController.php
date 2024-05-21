<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // register user mobile
        $request->validated();

        $fileName = null;
        if ($request->hasFile('img_profile')) {
            $file = $request->file('img_profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName);
        }

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'img_profile' => $fileName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tgl_lahir' => $request->tgl_lahir,
            'progdi' => $request->progdi,
            'gender' => $request->gender,
        ];

        $user = User::create($userData);

        // Tambahkan peran admin secara default jika user yang didaftarkan adalah admin
        if ($request->is_admin) {
            $user->is_admin = true;
            $user->save();
        }

        $token = $user->createToken('usm_hub')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function loginApi(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 422);
        }

        $token = $user->createToken('usm_hub')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'is_admin' => $user->isAdmin(),
        ], 200);
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }




    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect()->route('login');
    // }





    // public function logoutAdmin()
    // {
    //     // Logout admin
    //     Auth::logout();
    //     return redirect()->route('login.admin');
    // }


    // public function registerAdmin(RegisterRequest $request)
    // {
    //     // Register admin
    //     $request->validated();

    //     $userData = [
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'username' => $request->username,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'is_admin' => true,
    //     ];

    //     $user = User::create($userData);

    //     $token = $user->createToken('usm_hub')->plainTextToken;

    //     return response([
    //         'user' => $user,
    //         'token' => $token,
    //     ], 201);
    // }
}
