<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedRequest;
use Illuminate\Http\Request;
use App\Models\Feed;

class FeedController extends Controller
{
    public function __construct()
    {
        // Terapkan middleware admin ke metode-metode yang memerlukannya
        $this->middleware('admin')->only(['index', 'create', 'update', 'store', 'view']); // Menambahkan 'view' ke dalam middleware 'admin'
    }

    public function index()
    {
        // Mengambil semua feed
        $feeds = Feed::all();
        return response()->json($feeds, 200);
    }

    public function view($id)
    {
        // Menampilkan detail feed berdasarkan ID
        $feed = Feed::findOrFail($id);
        return response()->json($feed, 200);
    }

    public function create(FeedRequest $request)
    {
        // Membuat feed baru
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('uploads', 'public');
        }

        $feed = Feed::create([
            'kategori' => $request->input('kategori'),
            'judul' => $request->input('judul'),
            'deskripsi' => $request->input('deskripsi'),
            'file_path' => $filePath,
            'status' => false, // Default belum diupload
        ]);

        return response()->json([
            'message' => 'Feed berhasil dibuat',
            'feed' => $feed,
        ], 201);
    }

    public function update(FeedRequest $request, $id)
    {
        // Mengupdate feed
        $feed = Feed::findOrFail($id);
        $feed->update($request->all());

        return response()->json([
            'message' => 'Feed berhasil diupdate',
            'feed' => $feed,
        ], 200);
    }

    public function store($id)
    {
        // Mengubah status feed menjadi diupload
        $feed = Feed::findOrFail($id);
        $feed->status = true;
        $feed->save();

        return response()->json([
            'message' => 'Status feed berhasil diubah menjadi diupload',
            'feed' => $feed,
        ], 200);
    }
}
