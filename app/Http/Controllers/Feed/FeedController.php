<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedRequest;
use Illuminate\Http\Request;
use App\Models\Feed;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function getAllFeeds()
    {
        $user = Auth::user();

        $feeds = Feed::with('user')->get(); // Include user information
        return response()->json([
            'feeds' => $feeds,
        ], 200);
    }

    // Metode untuk mendapatkan feed berdasarkan ID
    public function getFeedById($id)
    {
        $feed = Feed::with('user')->findOrFail($id); // Include user information
        return response()->json(['feed' => $feed], 200);
    }
}