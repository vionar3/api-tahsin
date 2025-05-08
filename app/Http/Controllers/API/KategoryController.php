<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoryController extends Controller
{
    public function getKategoriByMateri($id_materi)
    {
        try {
            $kategori = Kategori::where('id_materi', $id_materi)->get();
            if ($kategori->isEmpty()) {
                return ResponseFormatter::error(null, 'Kategori tidak ditemukan', 404);
            }
            return ResponseFormatter::success($kategori, 'Kategori berdasarkan materi berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengambil data kategori', 500);
        }
    }
}
