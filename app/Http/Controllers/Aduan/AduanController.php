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
    /**
     * Menambahkan pengaduan baru.
     */
    public function createPengaduan(AduanRequest $request)
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // $photoPath = null;
        // if ($request->hasFile('bukti_photo')) {
        //     $photoPath = $request->file('bukti_photo')->store('photos', 'public');
        // }
        $photoPath = null;
        if ($request->hasFile('bukti_photo')) {
            $photoPath = $request->file('bukti_photo')->store('photos', 'public');
            // , tanpa 'photos/' di depannya
            $photoPath = basename($photoPath);
        }


        $pengaduan = Aduan::create([
            'user_id' => $user->id, //
            'jenis_pengaduan' => $request->jenis_pengaduan,
            'program_studi' => $request->program_studi,
            'keterangan' => $request->keterangan,
            'rating' => $request->rating,
            'bukti_photo' => $photoPath,
        ]);

        return response()->json([
            'message' => 'Pengaduan berhasil dibuat',
            'pengaduan' => $pengaduan
        ], 201);
    }



    public function view()
    {
        return view('pengaduan.view');
    }
}
