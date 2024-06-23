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

        $feeds = Feed::all();
        return response()->json(['feeds' => $feeds], 200);
    }

    // Metode untuk mendapatkan feed berdasarkan ID
    public function getFeedById($id)
    {
        $feeds = Feed::findOrFail($id);
        return response()->json(['feeds' => $feeds], 200);
    }
}
