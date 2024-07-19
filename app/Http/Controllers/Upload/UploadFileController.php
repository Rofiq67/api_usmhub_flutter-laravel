<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public function uploadKomentar(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        // Save file to api_usmhub
        $path = $request->file('file')->store('file_komentar', 'public');

        // Optionally, save file to admin_usmhub
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $destinationPath = storage_path('app/public/admin_usmhub/file_komentar');
        $file->move($destinationPath, $fileName);

        return response()->json(['path' => $path], 200);
    }

    public function uploadFeed(Request $request)
    {
        $request->validate([
            'doc_feed' => 'nullable|file|mimes:pdf|max:2048',
            'img_banner' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $docFeedPath = null;
        $imgBannerPath = null;

        // Handle doc_feed
        if ($request->hasFile('doc_feed')) {
            $docFeedFile = $request->file('doc_feed');
            $docFeedFileName = $docFeedFile->getClientOriginalName();

            // Save file to api_usmhub
            $docFeedPath = $docFeedFile->storeAs('documents', $docFeedFileName, 'public');

            // Save file to admin_usmhub
            $destinationPath = storage_path('app/public/admin_usmhub/documents');
            $docFeedFile->move($destinationPath, $docFeedFileName);
        }

        // Handle img_banner
        if ($request->hasFile('img_banner')) {
            $imgBannerFile = $request->file('img_banner');
            $imgBannerFileName = $imgBannerFile->getClientOriginalName();

            // Save file to api_usmhub
            $imgBannerPath = $imgBannerFile->storeAs('photos', $imgBannerFileName, 'public');

            // Save file to admin_usmhub
            $destinationPath = storage_path('app/public/admin_usmhub/photos');
            $imgBannerFile->move($destinationPath, $imgBannerFileName);
        }

        return response()->json([
            'doc_feed_path' => $docFeedPath,
            'img_banner_path' => $imgBannerPath,
        ], 200);
    }
}
