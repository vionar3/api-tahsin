<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;

class UploadAudioController extends Controller
{
   public function uploadAudio(Request $request)
    {
        // Validasi file
        $request->validate([
            'recorded_audio' => 'required|max:10240',  // Batasi ukuran file (misalnya 10MB)
            'sub_materi_id' => 'required|exists:sub_materi,id', // Validasi sub_materi_id
            'id_latihan' => 'required|exists:latihan,id', // Validasi id_latihan
        ]);

        // Mendapatkan user_id dari autentikasi token
        $user_id = auth()->user()->id;

        // Mendapatkan file dari request
        $file = $request->file('recorded_audio');

        // Menyimpan file di disk public
        $path = $file->store('audio_files', 'public');  // Menyimpan di folder `storage/app/public/audio_files`

        // Menyimpan data ke tabel Progress
        $progress = Progress::create([
            'user_id' => $user_id,
            'sub_materi_id' => $request->sub_materi_id,
            'id_latihan' => $request->id_latihan,
            'recorder_audio' => $path, // Simpan path file audio
        ]);

        return response()->json([
            'message' => 'File berhasil diupload dan data progress tersimpan!',
            'file_path' => $path,
            'progress' => $progress,
        ], 200);
    }
}
