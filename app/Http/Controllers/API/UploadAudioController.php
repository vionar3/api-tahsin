<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadAudioController extends Controller
{
    public function uploadAudio(Request $request)
    {
        print($request->file('recorded_audio'));
        // Validasi file
        $request->validate([
            // 'recorded_audio' => 'required|mimes:m4a,mp3,wav|max:10240',  // Batasi ukuran file (misalnya 10MB)
            'recorded_audio' => 'required|mimes:m4a,mp3,wav',  // Batasi ukuran file (misalnya 10MB)
        ]);

        // Mendapatkan file dari request
        $file = $request->file('recorded_audio');

        // Menyimpan file di disk public
        $path = $file->store('audio_files', 'public');  // Menyimpan di folder `storage/app/public/audio_files`

        return response()->json([
            'message' => 'File berhasil diupload!',
            'file_path' => $path
        ], 200);
    }
}
