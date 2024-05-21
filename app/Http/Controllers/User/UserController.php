<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function updateProfile(UsersRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('img_profile')) {
            $file = $request->file('img_profile');
            $path = $file->store('photos', 'public');
            $user->img_profile = $path;
        }

        $user->progdi = $request->progdi;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->gender = $request->gender;
        $user->alamat = $request->alamat;

        $user->save();

        return response()->json([
            'message' => 'Data berhasil di update',
            'user' => $user,
        ], 200);
    }
}
