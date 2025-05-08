<?php

namespace App\Http\Controllers\API;

use App\Models\Materi;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MateriControler extends Controller
{
    public function getMateri()
    {
        try {
            $materi = Materi::all();
            return ResponseFormatter::success($materi, 'Daftar materi berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengambil data materi', 500);
        }
    }
}
