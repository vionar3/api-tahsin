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
            $subMateri = SubMateri::where('id_kategori', $id_kategori)->get();
            if ($subMateri->isEmpty()) {
                return ResponseFormatter::error(null, 'Sub materi tidak ditemukan', 404);
            }
            return ResponseFormatter::success($subMateri, 'Sub materi berdasarkan kategori berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengambil data sub materi', 500);
        }
    }
}
