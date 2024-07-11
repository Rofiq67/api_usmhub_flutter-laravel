<?php

namespace App\Http\Controllers\Aspirasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\AspirasiRequest;
use App\Models\Aspirasi;
use App\Models\Aspriasi;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    public function riwayatAspirasi()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login

        // Ambil semua aspirasi berdasarkan user_id
        $riwayat = Aspirasi::where('user_id', $user->id)->get();

        return response()->json($riwayat, 200);
    }


    //
    public function createAspirasi(AspirasiRequest $request)
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $isAnonymous = $request->has('is_anonymous') ? $request->is_anonymous : false;

        $aspirasi = Aspirasi::create([
            'user_id' => $user->id, // Set user_id berdasarkan pengguna yang sedang login
            'jenis_aspirasi' => $request->jenis_aspirasi,
            'program_studi' => $request->program_studi,
            'keterangan' => $request->keterangan,
            'rating' => $request->rating,
            'is_anonymous' => $isAnonymous,
        ]);

        return response()->json([
            'message' => 'Aspirasi berhasil dibuat',
            'aspirasi' => $aspirasi
        ], 201);
    }
}
