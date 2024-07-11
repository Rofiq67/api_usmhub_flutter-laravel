<?php

namespace App\Http\Controllers\Aduan;

use App\Http\Controllers\Controller;
use App\Http\Requests\AduanRequest;
use App\Models\Aduan;
use App\Models\HistoryForward;
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

        // Ambil nilai is_anonymous dari request, default-nya false jika tidak ada
        $isAnonymous = $request->has('is_anonymous') ? $request->is_anonymous : false;

        $pengaduan = Aduan::create([
            'user_id' => $user->id,
            'jenis_pengaduan' => $request->jenis_pengaduan,
            'program_studi' => $request->program_studi,
            'keterangan' => $request->keterangan,
            'rating' => $request->rating,
            'bukti_photo' => $photoPath,
            'status' => 'Belum Dibaca',
            'is_anonymous' => $isAnonymous,
        ]);

        return response()->json([
            'message' => 'Pengaduan berhasil dibuat',
            'pengaduan' => $pengaduan,
        ], 201);
    }


    public function getHistoryForward($id)
    {
        $user = Auth::user();

        $pengaduan = Aduan::findOrFail($id);

        if ($pengaduan->user_id !== $user->id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk melihat aduan ini.'], 403);
        }

        // Ambil riwayat penerusan aduan terbaru
        $riwayatTerusan = HistoryForward::where('aduan_id', $pengaduan->id)
            ->latest() // Mengambil data terbaru berdasarkan waktu
            ->first(); // Mengambil hanya satu data terbaru

        return response()->json([
            'pengaduan' => $pengaduan,
            'riwayat_terusan' => $riwayatTerusan
        ], 200);
    }
}
