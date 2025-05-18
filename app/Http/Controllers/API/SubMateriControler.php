<?php

namespace App\Http\Controllers\API;

use App\Models\SubMateri;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubMateriControler extends Controller
{
    public function getSubMateriByKategori($id_kategori)
    {
        try {
            // Retrieve the category along with the related sub-materi
            $kategori = SubMateri::with('kategori')
                ->where('id_kategori', $id_kategori)
                ->get();

            // Check if any sub-materi was found
            if ($kategori->isEmpty()) {
                return ResponseFormatter::error(null, 'Sub materi tidak ditemukan', 404);
            }

            // Return the response with the data
            return ResponseFormatter::success([
                'id' => $kategori[0]->kategori->id,  // Category ID
                'id_materi' => $kategori[0]->kategori->id_materi,  // Materi ID
                'nama_kategori' => $kategori[0]->kategori->nama_kategori,  // Category name
                'created_at' => $kategori[0]->kategori->created_at,  // Category created at
                'updated_at' => $kategori[0]->kategori->updated_at,  // Category updated at
                'sub_materi' => $kategori->map(function ($subMateri) {
                    return [
                        'id' => $subMateri->id,
                        'id_kategori' => $subMateri->id_kategori,
                        'title' => $subMateri->title,
                        'subtitle' => $subMateri->subtitle,
                        'video_url' => $subMateri->video_url,
                        'intro' => $subMateri->intro,
                        'created_at' => $subMateri->created_at,
                        'updated_at' => $subMateri->updated_at,
                    ];
                })
            ], 'Sub materi berdasarkan kategori berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengambil data sub materi', 500);
        }
    }
}
