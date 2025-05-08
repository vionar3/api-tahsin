<?php

namespace App\Http\Controllers\API;

use App\Models\Latihan;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LatihanControler extends Controller
{
    public function getLatihanBySubMateri($id_submateri)
    {
        try {
            $latihan = Latihan::where('id_submateri', $id_submateri)->get();
            if ($latihan->isEmpty()) {
                return ResponseFormatter::error(null, 'Latihan tidak ditemukan', 404);
            }
            return ResponseFormatter::success($latihan, 'Latihan berdasarkan sub materi berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengambil data latihan', 500);
        }
    }
}
