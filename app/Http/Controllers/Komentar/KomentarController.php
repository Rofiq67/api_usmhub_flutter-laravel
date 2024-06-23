<?php

namespace App\Http\Controllers\Komentar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Aduan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KomentarController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Pastikan aduan_id ada dalam query string
    //     $aduan_id = $request->query('aduan_id');

    //     // Validasi aduan_id
    //     if (!$aduan_id) {
    //         return response()->json(['error' => 'Aduan ID harus disertakan dalam query string'], 400);
    //     }

    //     // Ambil komentar berdasarkan aduan_id
    //     $komentars = Komentar::where('aduan_id', $aduan_id)->get();
    //     return response()->json(['komentars' => $komentars], 200);
    // }

    public function getKomentar($aduan_id)
    {
        $komentar = Komentar::whereAduanId($aduan_id)->get();

        return response([
            'komentar' => $komentar
        ], 200);
    }


    public function kirimKomentar(Request $request, $aduan_id)
    {
        $request->validate([
            'aduan_id' => 'required|exists:aduans,id',
            'text' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $file = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('file_komentar', 'public');
        }

        $komentar = Komentar::create([
            'aduan_id' => $request->aduan_id,
            'user_id' => Auth::id(),
            'text' => $request->text,
            'file' => $file,
        ]);

        return response()->json(['message' => 'Komentar berhasil dikirim', 'komentar' => $komentar], 201);
    }

    // public function updateKomentar(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'text' => 'nullable|string',
    //         'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     $komentar = Komentar::findOrFail($id);

    //     // Verifikasi hak akses pengguna
    //     if (Auth::user()->id !== $komentar->user_id) {
    //         return response()->json(['error' => 'Anda tidak memiliki izin untuk memperbarui komentar ini'], 403);
    //     }

    //     $komentar->text = $request->input('text', $komentar->text);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file')->store('file_komentar', 'public');
    //         if ($komentar->file) {
    //             Storage::disk('public')->delete($komentar->file);
    //         }
    //         $komentar->file = $file;
    //     }


    //     $komentar->save();

    //     return response()->json(['message' => 'Komentar berhasil diperbarui', 'komentar' => $komentar], 200);
    // }

    public function updateKomentar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $komentar = Komentar::findOrFail($id);

        // Verifikasi hak akses pengguna
        if (Auth::user()->id !== $komentar->user_id) {
            return response()->json(['error' => 'Anda tidak memiliki izin untuk memperbarui komentar ini'], 403);
        }

        $komentar->text = $request->input('text', $komentar->text);

        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('file_komentar', 'public');
            if ($komentar->file) {
                Storage::disk('public')->delete($komentar->file);
            }
            $komentar->file = $file;
        }

        $komentar->save();

        return response()->json(['message' => 'Komentar berhasil diperbarui', 'komentar' => $komentar], 200);
    }



    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);

        // Check if the user is authorized to delete the comment
        if ($komentar->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $komentar->delete();
        return response()->json(['message' => 'Komentar berhasil dihapus'], 200);
    }
}
