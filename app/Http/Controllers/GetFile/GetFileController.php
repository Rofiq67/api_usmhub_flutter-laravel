<?php

namespace App\Http\Controllers\GetFile;

use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GetFileController extends Controller
{
    public function getImage($filename)
    {
        $pathPhotos = 'public/photos/' . $filename;

        try {
            if (!Storage::exists($pathPhotos)) {
                abort(404);
            }

            $file = Storage::get($pathPhotos);
            $type = Storage::mimeType($pathPhotos);

            return response($file, 200)->header('Content-Type', $type);
        } catch (\Exception $e) {
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function getDoc($filedoc)
    {
        $pathDoc = 'public/documents/' . $filedoc;

        try {
            if (!Storage::exists($pathDoc)) {
                abort(404);
            }

            $file = Storage::get($pathDoc);
            $type = Storage::mimeType($pathDoc);

            // Set MIME type specifically for PDF
            if ($type == 'application/pdf') {
                return response($file, 200)->header('Content-Type', 'application/pdf');
            } else {
                // Handle other document types if needed
                return response($file, 200)->header('Content-Type', $type);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'File not found'], 404);
        }
    }


    public function getFileKomentar($filekomentar)
    {
        $pathAdminUsmhub = 'public/admin_usmhub/file_komentar/' . $filekomentar;
        $pathApiUsmhub = 'public/file_komentar/' . $filekomentar;

        try {
            if (Storage::exists($pathAdminUsmhub)) {
                $file = Storage::get($pathAdminUsmhub);
            } elseif (Storage::exists($pathApiUsmhub)) {
                $file = Storage::get($pathApiUsmhub);
            } else {
                abort(404);
            }

            $type = Storage::mimeType($pathAdminUsmhub); // Using admin_usmhub path for consistency

            return response($file, 200)->header('Content-Type', $type);
        } catch (\Exception $e) {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
