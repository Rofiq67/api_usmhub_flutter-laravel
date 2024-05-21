<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedRequest;
use Illuminate\Http\Request;
use App\Models\Feed;

class FeedController extends Controller
{
    //new feed
    public function latest()
    {
        $feeds = Feed::where('uploaded', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Feed Terbaru',
            'data' => $feeds
        ]);
    }
}
