<?php

namespace App\Http\Controllers\Komentar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Aduan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class KomentarController extends Controller
{

    public function getKomentar($aduan_id)
    {
        $komentar = Komentar::with('user')->whereAduanId($aduan_id)->get();

        return response([
            'komentar' => $komentar,
        ], 200);
    }

    public function kirimKomentar(Request $request)
    {
        $request->validate([
            'aduan_id' => 'required|exists:aduans,id',
            'text' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $file = null;
        if ($request->hasFile('file')) {
            // Save file to api_usmhub
            $file = $request->file('file')->storeAs('file_komentar', $request->file('file')->getClientOriginalName(), 'public');

            // Save file to admin_usmhub
            $response = Http::attach(
                'file',
                file_get_contents($request->file('file')->getRealPath()),
                $request->file('file')->getClientOriginalName()
            )->post('http://127.0.0.1:8000/api/upload/komentar'); // Replace with your local server address

            if ($response->successful()) {
                // Optionally handle response or errors from API
            } else {
                return redirect()->back()->with('error', 'Failed to upload file to Admin');
            }
        }

        $komentar = Komentar::create([
            'aduan_id' => $request->aduan_id,
            'user_id' => Auth::id(),
            'text' => $request->text,
            'file' => $file,
        ]);

        return response()->json(['message' => 'Komentar berhasil dikirim', 'komentar' => $komentar], 201);
    }

    // public function kirimKomentar(Request $request, $aduan_id)
    // {
    //     $request->validate([
    //         'aduan_id' => 'required|exists:aduans,id',
    //         'text' => 'nullable|string',
    //         'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
    //     ]);

    //     $file = null;
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file')->store('file_komentar', 'public');
    //     }

    //     $komentar = Komentar::create([
    //         'aduan_id' => $request->aduan_id,
    //         'user_id' => Auth::id(),
    //         'text' => $request->text,
    //         'file' => $file,
    //     ]);

    //     return response()->json(['message' => 'Komentar berhasil dikirim', 'komentar' => $komentar], 201);
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

        if ($request->hasFile('file')) {
            // Save file to api_usmhub
            $file = $request->file('file')->storeAs('file_komentar', $request->file('file')->getClientOriginalName(), 'public');

            // Save file to admin_usmhub
            $response = Http::attach(
                'file',
                file_get_contents($request->file('file')->getRealPath()),
                $request->file('file')->getClientOriginalName()
            )->post('http://127.0.0.1:8000/api/upload/komentar'); // Replace with your local server address

            if (!$response->successful()) {
                return redirect()->back()->with('error', 'Failed to upload file to Admin');
            }

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