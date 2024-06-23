<?php

namespace App\Http\Controllers\Aduan;

use App\Http\Controllers\Controller;
use App\Http\Requests\AduanRequest;
use App\Models\Aduan;
use Illuminate\Support\Facades\Auth;

class AduanController extends Controller
{
    public function riwayatPengaduan()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login

        // Ambil semua pengaduan berdasarkan user_id
        $riwayat = Aduan::where('user_id', $user->id)->get();

        return response()->json($riwayat, 200);
    }

    public function createPengaduan(AduanRequest $request)
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $photoPath = null;
        if ($request->hasFile('bukti_photo')) {
            $photo = $request->file('bukti_photo');
            $photoPath = $photo->store('photos', 'public');
            $photoPath = $photo->getClientOriginalName(); // Mengambil nama file asli tanpa path
            $photoPath = asset($photoPath); // Mengubahpath menjadi URL
            // $photoPath = asset('storage/' . $photoPath);
        }


        $pengaduan = Aduan::create([
            'user_id' => $user->id, //
            'jenis_pengaduan' => $request->jenis_pengaduan,
            'program_studi' => $request->program_studi,
            'keterangan' => $request->keterangan,
            'rating' => $request->rating,
            'bukti_photo' => $photoPath,
            'status' => 'Belum Dibaca', // Default status
        ]);

        return response()->json([
            'message' => 'Pengaduan berhasil dibuat',
            'pengaduan' => $pengaduan,
            'bukti_photo' => $photoPath,
        ], 201);
    }
}
