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
use Illuminate\Support\Facades\DB;

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

    // Ambil progres terbaru untuk setiap submateri berdasarkan user_id dan submateri_id
    $completedSubmateriQuery = Progress::where('user_id', $user->id)
                                       ->where('status', 'selesai') // Hanya yang selesai
                                       ->orderBy('updated_at', 'desc') // Mengurutkan berdasarkan updated_at
                                       ->get();

    // Filter hanya progres terbaru untuk setiap submateri
    $completedSubmateri = $completedSubmateriQuery->unique('sub_materi_id');

    // Menghitung jumlah submateri yang telah selesai (terbaru)
    $completedCount = $completedSubmateri->count();

    // Menghitung persentase progres
    $progressPercentage = ($totalSubmateri > 0) ? ($completedCount / $totalSubmateri) * 100 : 0;

    // Return hasil persentase progres
    return response()->json([
        'user_id' => $user->id,
        'nama_lengkap' => $user->nama_lengkap,
        'total_submateri' => $totalSubmateri,
        'completed_submateri' => $completedCount,
        'progress_percentage' => $progressPercentage
    ]);
}


public function updateStatusBatch(Request $request)
{
    // Validasi input hanya array of ID
    $request->validate([
        'progress_ids' => 'required|array|min:1',
        'progress_ids.*' => 'integer|exists:progress,id',
    ]);

    $progressIds = $request->input('progress_ids');

    // Update status menjadi 'menunggu'
    Progress::whereIn('id', $progressIds)->update(['status' => 'menunggu']);

    return response()->json([
        'message' => 'Status berhasil diubah menjadi menunggu.',
        'updated_ids' => $progressIds,
    ]);
}

public function progressMenunggu()
{
    $progressList = Progress::where('status', 'menunggu')
        ->with([
            'user:id,nama_lengkap',
            'subMateri:id,title,subtitle'
        ])
        ->orderByDesc('created_at')
        ->get();

    // Filter unik berdasarkan kombinasi user_id dan sub_materi_id
    $filtered = $progressList->unique(fn($item) => $item->user_id . '-' . $item->sub_materi_id);

    $data = $filtered->map(function ($progress) {
        return [
            'user_id' => $progress->user_id,
            'sub_materi_id' => $progress->sub_materi_id,
            'nama_lengkap' => $progress->user->nama_lengkap,
            'title' => $progress->subMateri->title,
            'subtitle' => $progress->subMateri->subtitle,
            'status' => $progress->status,
            'created_at' => $progress->created_at,
            // 'audio_file' => $progress->recorder_audio,
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Data progress santri dengan status menunggu',
        'data' => $data->values(), // reset index
    ]);
}

public function getProgressLatihanByUserAndSubmateri($user_id, $sub_materi_id)
{
    // Ambil data progress untuk user dan sub_materi_id yang diberikan
    $progressList = Progress::where('user_id', $user_id)
        ->where('sub_materi_id', $sub_materi_id)
        ->with(['latihan', 'subMateri'])
        ->orderBy('updated_at', 'desc') // Mengurutkan berdasarkan updated_at secara descending
        ->limit(3) // Batasi hanya 3 data terbaru
        ->get();

    // Jika data progress kosong, kembalikan respons bahwa tidak ada data
    if ($progressList->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Tidak ada progress ditemukan',
            'data' => []
        ]);
    }

    // Memetakan data progress untuk menambahkan status_validasi, feedback_pengajar, dan total_nilai
    $data = $progressList->map(function ($item) {
        return [
            'id_progress' => $item->id,
            'title' => $item->subMateri->title ?? '',
            'subtitle' => $item->subMateri->subtitle ?? '',
            'id_latihan' => $item->id_latihan,
            'potongan_ayat' => $item->latihan->potongan_ayat ?? null,
            'latin_text' => $item->latihan->latin_text ?? null,
            'status' => $item->status,  // Status dari progress
            'status_validasi' => $item->status_validasi, // status_validasi yang ditambahkan
            'feedback_pengajar' => $item->feedback_pengajar, // feedback_pengajar yang ditambahkan
            'nilai' => $item->nilai,  // Nilai dari progress
            'recorder_audio' => $item->recorder_audio,
            'total_nilai' => $item->total_nilai, // total_nilai yang ditambahkan
        ];
    });

    // Mengembalikan data progress latihan yang berhasil diambil beserta informasi tambahan
    return response()->json([
        'status' => true,
        'message' => 'Data progress latihan berhasil diambil',
        'data' => $data
    ]);
}



public function savePenilaian(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'id_progress' => 'required|array',
        'id_progress.*' => 'exists:progress,id',  // Ensure the progress id exists
        'status_validasi' => 'required|array',
        'status_validasi.*' => 'in:benar,salah', // Status must be 'benar' or 'salah'
        'feedback_pengajar' => 'nullable|array',
        'feedback_pengajar.*' => 'nullable|string',
        'nilai' => 'required|array',
        'nilai.*' => 'integer|min:0|max:100', // Ensure each nilai is between 0 and 100
    ]);

    // Start the DB transaction
    DB::beginTransaction();

    try {
        $totalNilaiSum = 0;
        $nilaiCount = 0;
        $updatedProgress = [];

        // Loop through each id_progress to update each record individually
        foreach ($validatedData['id_progress'] as $index => $id_progress) {
            // Find the Progress record
            $progress = Progress::findOrFail($id_progress);

            // Update the progress record
            $progress->status_validasi = $validatedData['status_validasi'][$index];
            $progress->feedback_pengajar = $validatedData['feedback_pengajar'][$index] ?? null;
            $progress->nilai = $validatedData['nilai'][$index];
            $progress->save();

            // Add nilai to the total sum for average calculation
            $totalNilaiSum += $progress->nilai;
            $nilaiCount++;

            // Collect updated progress data
            $updatedProgress[] = [
                'id_progress' => $progress->id,
                'status_validasi' => $progress->status_validasi,
                'feedback_pengajar' => $progress->feedback_pengajar,
                'nilai' => $progress->nilai,
            ];
        }

        // Calculate the total_nilai (average)
        $total_nilai = $nilaiCount > 0 ? $totalNilaiSum / $nilaiCount : 0;

        // Determine the status based on total_nilai
        $status = ($total_nilai > 70) ? 'selesai' : 'gagal';

        // Update total_nilai and status for each id_progress
        foreach ($validatedData['id_progress'] as $index => $id_progress) {
            $progress = Progress::findOrFail($id_progress);
            $progress->total_nilai = $total_nilai;
            $progress->status = $status; // Set the status based on the total_nilai
            $progress->save();
        }

        // Commit the transaction
        DB::commit();

        // Return the updated progress data along with total_nilai and status
        return response()->json([
            'status' => true,
            'message' => 'Penilaian berhasil disimpan',
            'data' => [
                'total_nilai' => $total_nilai,
                'status' => $status, // Include status in the response
                'progress' => $updatedProgress,
            ]
        ], 200);

    } catch (\Exception $e) {
        // Rollback the transaction in case of error
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan saat menyimpan penilaian',
            'error' => $e->getMessage(),
        ], 500);
    }
}



}

