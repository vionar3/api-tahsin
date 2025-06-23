<?php

// app/Http/Controllers/Api/ProgressController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\Models\Materi;
use App\Models\user;
use App\Models\Latihan;
use App\Models\SubMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter; 

class ProgressController extends Controller
{

     public function __construct()
    {
        // Menambahkan middleware untuk otentikasi dengan token
        $this->middleware('auth:sanctum');
    }

    // Method untuk mendapatkan progres materi
    public function getMateriProgress($materiId)
    {
        // Ambil user yang terotentikasi
        $user = Auth::user();

        // Ambil materi berdasarkan ID
        $materi = Materi::findOrFail($materiId);

        // Menghitung total kategori dan submateri yang selesai
        $totalSubmateri = 0;
        $completedSubmateri = 0;

        // Looping untuk setiap kategori dari materi
        foreach ($materi->kategori as $kategori) {
            $totalSubmateri += $kategori->subMateri()->count();

            // Menghitung jumlah submateri yang selesai untuk kategori ini
            $completedSubmateri += Progress::where('user_id', $user->id)
                                           ->where('status', 'selesai')
                                           ->whereIn('sub_materi_id', $kategori->subMateri->pluck('id'))
                                           ->count();
        }

        // Menghitung persentase progres
        $progressPercentage = ($totalSubmateri > 0) ? ($completedSubmateri / $totalSubmateri) * 100 : 0;

        return response()->json([
            'materi' => $materi->title,
            'total_submateri' => $totalSubmateri,
            'completed_submateri' => $completedSubmateri,
            'progress_percentage' => $progressPercentage
        ]);
    }

    // Method untuk update progress
    public function updateProgress(Request $request, $subMateriId)
    {
        $user = Auth::user();

        // Update atau buat data progres baru
        $progress = Progress::updateOrCreate(
            ['user_id' => $user->id, 'sub_materi_id' => $subMateriId],
            ['status' => 'selesai']
        );

        return response()->json(['message' => 'Progress updated successfully']);
    }

    public function getProgressBySubMateri($subMateriId)
{
    // Ambil user yang terotentikasi
    $user = Auth::user();

    // Cek apakah ada progres untuk user ini pada submateri yang dimaksud, ambil yang terbaru
    $progress = Progress::where('user_id', $user->id)
                        ->where('sub_materi_id', $subMateriId)
                        ->latest() // Mengambil data yang paling baru berdasarkan 'updated_at'
                        ->first();

    // Jika progres ada, kembalikan statusnya
    if ($progress) {
        return response()->json([
            'sub_materi_id' => $subMateriId,
            'status' => $progress->status, // 'selesai', 'gagal', atau status lainnya
            'message' => 'Progress found',
        ]);
    }

    // Jika tidak ada progres, kembalikan status belum selesai
    return response()->json([
        'sub_materi_id' => $subMateriId,
        'status' => 'belum selesai', // Default status
        'message' => 'No progress found',
    ]);
}


 public function getProgressPercentage(Request $request)
    {
        // Ambil user yang terotentikasi
        $user = Auth::user();

        // Ambil semua submateri yang ada di sistem
        $totalSubmateri = SubMateri::count(); // Menghitung semua submateri yang ada
        $completedSubmateri = Progress::where('user_id', $user->id)
                                        ->where('status', 'selesai')
                                        ->count(); // Menghitung submateri yang statusnya selesai

        // Menghitung persentase progres
        $progressPercentage = ($totalSubmateri > 0) ? ($completedSubmateri / $totalSubmateri) * 100 : 0;

        // Return hasil persentase progres
        return response()->json([
            'user_id' => $user->id,
            'nama_lengkap' => $user->nama_lengkap,
            'total_submateri' => $totalSubmateri,
            'completed_submateri' => $completedSubmateri,
            'progress_percentage' => $progressPercentage
        ]);
    }

    public function getProgressPercentageById(Request $request, $user_id)
{
    // Validasi user_id jika diperlukan
    if (!User::find($user_id)) {
        return response()->json([
            'message' => 'User not found',
        ], 404);
    }

    // Ambil user berdasarkan ID
    $user = User::find($user_id);

    // Ambil semua submateri yang ada di sistem
    $totalSubmateri = SubMateri::count(); // Menghitung semua submateri yang ada
    $completedSubmateri = Progress::where('user_id', $user->id)
                                    ->where('status', 'selesai')
                                    ->count(); // Menghitung submateri yang statusnya selesai

    // Menghitung persentase progres
    $progressPercentage = ($totalSubmateri > 0) ? ($completedSubmateri / $totalSubmateri) * 100 : 0;

    // Return hasil persentase progres
    return response()->json([
        'user_id' => $user->id,
        'nama_lengkap' => $user->nama_lengkap,
        'total_submateri' => $totalSubmateri,
        'completed_submateri' => $completedSubmateri,
        'progress_percentage' => $progressPercentage
    ]);
}


public function saveRecordedAudioName(Request $request, $id_latihan)
    {
        // Validasi data yang masuk
        $request->validate([
            'recorded_audio' => 'required|string', // Nama file audio yang disimpan
        ]);

        // Temukan latihan berdasarkan ID (tanpa memeriksa user_id)
        $latihan = Latihan::find($id_latihan);

        // Jika latihan ditemukan, simpan nama file rekaman ke kolom recorder_audio
        if ($latihan) {
            $latihan->recorder_audio = $request->recorded_audio;
            $latihan->status = 'benar'; // Status latihan diubah menjadi selesai
            $latihan->save();

            return response()->json([
                'message' => 'Rekaman berhasil disimpan!',
                'latihan' => $latihan,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Latihan tidak ditemukan.',
            ], 404);
        }
    }

    // API untuk menyimpan data progres latihan yang telah diselesaikan
    public function saveProgress(Request $request, $submateri_id)
    {
        // Validasi data yang masuk
        $request->validate([
            'latihan_ids' => 'required|array', // Array dari ID latihan yang telah diselesaikan
            'latihan_ids.*' => 'exists:latihan,id', // Pastikan ID latihan ada di tabel latihan
        ]);

        // Ambil user_id dari token yang digunakan (auth)
        $user_id = Auth::id(); // Mendapatkan ID pengguna yang terautentikasi

        // Ambil data submateri untuk menampilkan title
        $submateri = SubMateri::find($submateri_id);
        if (!$submateri) {
            return response()->json(['message' => 'SubMateri tidak ditemukan'], 404);
        }

        // Menyimpan progres untuk setiap latihan yang diselesaikan oleh pengguna
        $savedProgress = [];
        foreach ($request->latihan_ids as $latihanId) {
            // Temukan latihan berdasarkan ID
            $latihan = Latihan::find($latihanId);

            // Jika latihan ditemukan, simpan ke tabel progres
            if ($latihan) {
                $progress = Progress::updateOrCreate(
                    [
                        'user_id' => $user_id, // Gunakan user_id dari token
                        'sub_materi_id' => $submateri_id,
                        'id_latihan' => $latihan->id,
                    ],
                    [
                        'status' => 'menunggu', // Status latihan diatur sebagai 'menunggu' setelah selesai
                        'nilai' => $latihan->nilai, // Nilai latihan yang diberikan oleh pengajar
                    ]
                );

                // Menambahkan data progres yang baru disimpan untuk ditampilkan
                $savedProgress[] = [
                    'user_id' => $user_id,
                    'sub_materi_id' => $submateri_id,
                    'submateri_title' => $submateri->title, // Menambahkan title dari submateri
                    'status' => 'menunggu',
                    'id_latihan' => $latihan->id,
                    'potongan_ayat' => $latihan->potongan_ayat,
                    'latin_text' => $latihan->latin_text,
                    'recorder_audio' => $latihan->recorder_audio,
                ];
            }
        }

        return response()->json([
            'message' => 'Progres latihan berhasil disimpan.',
            'progress' => $savedProgress,
        ], 200);
    }

    public function getHasilPenilaianByUserAndSubMateri($submateri_id)
{
    // Ambil user_id dari token yang digunakan (auth)
    $user_id = Auth::id(); // Mendapatkan ID pengguna yang terautentikasi

    // Ambil data berdasarkan user_id dan submateri_id
    $progressData = Progress::with([
            'latihan' => function ($query) {
                $query->select('id', 'potongan_ayat', 'latin_text', 'recorder_audio', 'feedback_pengajar', 'status');
            }
        ])
        ->where('user_id', $user_id) // Mengambil progress berdasarkan user_id yang terautentikasi
        ->where('sub_materi_id', $submateri_id) // Mengambil progress berdasarkan submateri_id
        ->get(['user_id', 'sub_materi_id', 'id_latihan', 'nilai']); // Pilih data yang diperlukan dari tabel progress

    // Cek apakah ada data progress
    if ($progressData->isEmpty()) {
        return response()->json(['message' => 'Tidak ada data progres untuk pengguna ini pada submateri ini'], 404);
    }

    // Menyiapkan hasil yang akan dikembalikan
    $results = $progressData->map(function ($progress) {
        return [
            'user_id' => $progress->user_id,
            'sub_materi_id' => $progress->sub_materi_id,
            'id_latihan' => $progress->id_latihan,
            'nilai' => $progress->nilai,
            'potongan_ayat' => $progress->latihan->potongan_ayat,
            'latin_text' => $progress->latihan->latin_text,
            'recorder_audio' => $progress->latihan->recorder_audio,
            'feedback_pengajar' => $progress->latihan->feedback_pengajar,
            'status' => $progress->latihan->status,
        ];
    });

    return response()->json([
        'message' => 'Data hasil penilaian berhasil diambil.',
        'data' => $results
    ], 200);
}


}

