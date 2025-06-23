<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Progress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserControler extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'nama_lengkap' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:255'],
                'tgl_lahir' => ['required', 'date'],
                'nama_wali' => ['nullable', 'string', 'max:255'],
                'no_telp_wali' => ['nullable', 'string', 'max:255'],
                'peran' => ['required', 'in:santri,pengajar'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'tgl_lahir' => $request->tgl_lahir,
                'nama_wali' => $request->nama_wali,
                'no_telp_wali' => $request->no_telp_wali,
                'peran' => $request->peran,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error->getMessage(),
            ], 'Authentication Failed', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return ResponseFormatter::error([
                    'message' => 'email atau password salah'
                ], 'Authentication Failed', 401);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                // 'user' => $user
                'user' => [
        'peran' => $user->peran  // Pastikan 'status' ada di sini
    ]
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error->getMessage()
            ], 'Authentication Failed', 500);
        }
    }

    public function loginWithTelp(Request $request)
{
    try {
        $request->validate([
            'no_telp_wali' => 'required|string',  // Validate 'no_telp_wali'
            'password' => 'required'  // Validate password
        ]);

        // Find the user by 'no_telp_wali'
        $user = User::where('no_telp_wali', $request->no_telp_wali)->first();

        // Check if the user exists
        if (!$user) {
            return ResponseFormatter::error([
                'message' => 'No telepon salah'
            ], 'Authentication Failed', 401);
        }

        // Check if the password is correct
        if (!Hash::check($request->password, $user->password)) {
            return ResponseFormatter::error([
                'message' => 'Password salah'
            ], 'Authentication Failed', 401);
        }

        // Create token for the user
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => [
                'peran' => $user->peran  // Ensure 'peran' is included here
            ]
        ], 'Authenticated');
    } catch (Exception $error) {
        return ResponseFormatter::error([
            'message' => 'Something went wrong',
            'error' => $error->getMessage()
        ], 'Authentication Failed', 500);
    }
}



    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data berhasil di ambil');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function getUsersByRole(Request $request)
{
    try {
        // Ambil data user yang memiliki peran 'santri' dan urutkan berdasarkan created_at secara descending
        $users = User::where('peran', 'santri')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Jika tidak ada user dengan peran 'santri'
        if ($users->isEmpty()) {
            return ResponseFormatter::error(
                null,
                "Tidak ada pengguna dengan peran santri",
                404
            );
        }

        // Mengembalikan data pengguna dengan peran 'santri'
        return ResponseFormatter::success(
            $users,
            "Pengguna dengan peran santri berhasil ditemukan"
        );
    } catch (Exception $error) {
        return ResponseFormatter::error(
            ['message' => 'Something went wrong', 'error' => $error->getMessage()],
            'Terjadi kesalahan',
            500
        );
    }
}


public function getUserInfoById($id)
    {
        // Mencari user berdasarkan ID
        $user = User::find($id);

        // Jika pengguna tidak ditemukan, kembalikan response error
        if (!$user) {
            return ResponseFormatter::error(
                null,
                'User not found',
                404
            );
        }

        // Mengembalikan data pengguna dalam format JSON menggunakan ResponseFormatter
        return ResponseFormatter::success(
            [
                'id' => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
                'alamat' => $user->alamat,
                'usia' => $user->usia,
                'no_telp_wali' => $user->no_telp_wali,
                'email' => $user->email,
                'jenis_kelamin' => $user->jenis_kelamin,
                'jenjang_pendidikan' => $user->jenjang_pendidikan,
            ],
            'User data retrieved successfully'
        );
    }

    public function updateUserById(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'usia' => 'required|string|max:255',
            'no_telp_wali' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jenjang_pendidikan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return ResponseFormatter::error(
                null,
                'Validation Error',
                422
            );
        }

        // Find the user by ID
        $user = User::find($id);

        // If the user does not exist, return an error response
        if (!$user) {
            return ResponseFormatter::error(
                null,
                'User not found',
                404
            );
        }

        // Update the user's details
        $user->nama_lengkap = $request->nama_lengkap;
        $user->alamat = $request->alamat;
        $user->usia = $request->usia;
        $user->no_telp_wali = $request->no_telp_wali;
        $user->email = $request->email;
        $user->jenjang_pendidikan = $request->jenjang_pendidikan;
        $user->jenis_kelamin = $request->jenis_kelamin;

        // Save the updated user data
        $user->save();

        // Return success response
        return ResponseFormatter::success(
            $user,
            'User updated successfully'
        );
    }


    public function tambahSantri(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'nama_lengkap' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'usia' => 'required|string|max:255',
        'no_telp_wali' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
        'jenjang_pendidikan' => 'required|string|max:255',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return ResponseFormatter::error(
            null,
            'Validation Error',
            422
        );
    }

    // Ambil data santri dari request
    $santri = $request->only([
        'nama_lengkap', 'alamat', 'usia', 'no_telp_wali', 'email', 'jenis_kelamin', 'jenjang_pendidikan'
    ]);

    // Simpan santri ke database
    $santriInserted = User::create([
        'nama_lengkap' => $santri['nama_lengkap'],
        'alamat' => $santri['alamat'],
        'usia' => $santri['usia'],
        'no_telp_wali' => $santri['no_telp_wali'],
        'email' => $santri['email'],
        'jenis_kelamin' => $santri['jenis_kelamin'],
        'jenjang_pendidikan' => $santri['jenjang_pendidikan'],
        'peran' => 'santri',
        'password' => bcrypt($santri['email']), // password = email (dihash)
    ]);

    // Respon sukses
    return ResponseFormatter::success(
        $santriInserted,
        'Santri data imported successfully'
    );
}

 public function changePassword(Request $request)
{
    // Validasi inputan password baru
    $validator = Validator::make($request->all(), [
        'new_password' => 'required|string|min:8|confirmed',  // Pastikan password baru minimal 8 karakter dan dikonfirmasi
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors(),
        ], 400);
    }

    // Ambil user yang terautentikasi
    $user = Auth::user();

    // Update password pengguna secara manual
    DB::table('users')  // Gunakan query builder untuk update langsung
        ->where('id', $user->id)  // Menentukan user berdasarkan ID
        ->update(['password' => Hash::make($request->new_password)]);  // Enkripsi password baru dan simpan

    return response()->json([
        'status' => 'success',
        'message' => 'Password berhasil diubah',
    ], 200);
}

public function getUserInfoByToken(Request $request)
{
    // Mendapatkan pengguna yang terautentikasi
    $user = Auth::user();

    // Jika pengguna tidak ditemukan (misalnya, token tidak valid)
    if (!$user) {
        return ResponseFormatter::error(
            null,
            'User not found',
            404
        );
    }

    // Mengembalikan data pengguna dalam format JSON menggunakan ResponseFormatter
    return ResponseFormatter::success(
        [
            'id' => $user->id,
            'nama_lengkap' => $user->nama_lengkap,
            'alamat' => $user->alamat,
            'usia' => $user->usia,
            'no_telp_wali' => $user->no_telp_wali,
            'email' => $user->email,
            'jenis_kelamin' => $user->jenis_kelamin,
            'jenjang_pendidikan' => $user->jenjang_pendidikan,
        ],
        'User data retrieved successfully'
    );
}

public function updateUserByToken(Request $request)
{
    // Validasi data yang diterima
    $validator = Validator::make($request->all(), [
        'nama_lengkap' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'usia' => 'required|string|max:255',
        'no_telp_wali' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'jenjang_pendidikan' => 'required|string|max:255',
        'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
    ]);

    // Jika validasi gagal, kembalikan respons error
    if ($validator->fails()) {
        return ResponseFormatter::error(
            null,
            'Validation Error',
            422
        );
    }

    // Mendapatkan pengguna yang terautentikasi
    $user = Auth::user();

    // Jika pengguna tidak ditemukan (misalnya, token tidak valid)
    if (!$user) {
        return ResponseFormatter::error(
            null,
            'User not found',
            404
        );
    }

    // Menggunakan DB::table untuk memperbarui data pengguna secara manual
    DB::table('users')
        ->where('id', $user->id)
        ->update([
            'nama_lengkap' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'usia' => $request->usia,
            'no_telp_wali' => $request->no_telp_wali,
            'email' => $request->email,
            'jenjang_pendidikan' => $request->jenjang_pendidikan,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

    // Mengembalikan respons sukses
    return ResponseFormatter::success(
        null,
        'User updated successfully'
    );
}






    public function importSantri(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'santri' => 'required|array',
        'santri.*.nama_lengkap' => 'required|string|max:255',
        'santri.*.alamat' => 'required|string|max:255',
        'santri.*.usia' => 'required|string|max:255',
        'santri.*.no_telp_wali' => 'required|string|max:20',
        'santri.*.email' => 'required|email|max:255',
        'santri.*.jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
        'santri.*.jenjang_pendidikan' => 'required|string|max:255',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return ResponseFormatter::error(
            null,
            'Validation Error',
            422
        );
    }

    // Ambil data santri dari request
    $santriData = $request->input('santri');
    $santriInserted = [];

    // Simpan tiap santri ke database
    foreach ($santriData as $santri) {
        $santriInserted[] = User::create([
            'nama_lengkap' => $santri['nama_lengkap'],
            'alamat' => $santri['alamat'],
            'usia' => $santri['usia'],
            'no_telp_wali' => $santri['no_telp_wali'],
            'email' => $santri['email'],
            'jenis_kelamin' => $santri['jenis_kelamin'],
            'jenjang_pendidikan' => $santri['jenjang_pendidikan'],
            'peran' => 'santri',
            'password' => bcrypt('almuhajirin'), // password = email (dihash)
        ]);
    }

    // Respon sukses
    return ResponseFormatter::success(
        $santriInserted,
        'Santri data imported successfully'
    );
}

public function getUserProgres(Request $request)
{
    try {
        // Ambil semua user dengan peran 'santri'
        $santriUsers = User::where('peran', 'santri')->get(); // Ambil semua user dengan peran 'santri'

        // Jika tidak ada santri
        if ($santriUsers->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada santri yang ditemukan.',
            ], 404);  // Status code 404 (Not Found)
        }

        // Ambil progres untuk setiap santri dan filter yang sudah menyelesaikan submateri
        $santriProgressData = $santriUsers->map(function ($santri) {
            // Ambil progres latihan yang telah diselesaikan oleh santri berdasarkan user ID
            $progresData = Progress::where('user_id', $santri->id)
                                   ->where('status', 'selesai') // Menghitung submateri yang sudah selesai
                                   ->with('submateri') // Load data submateri yang terkait
                                   ->get();

            // Hitung jumlah submateri yang selesai
            $completedSubmateriCount = $progresData->count();  // Menghitung jumlah data progres yang selesai

            // Hanya tampilkan santri yang telah menyelesaikan submateri
            if ($completedSubmateriCount > 0) {
                return [
                    'user_id' => $santri->id,
                    'nama_lengkap' => $santri->nama_lengkap,
                    'no_telp_wali' => $santri->no_telp_wali,
                    'completed_submateri' => $completedSubmateriCount,  // Jumlah submateri yang telah selesai
                ];
            }
        })->filter(function ($santri) {
            return $santri !== null;  // Filter out santri that haven't completed any submateri
        });

        // Jika tidak ada santri yang menyelesaikan submateri
        if ($santriProgressData->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada santri yang telah menyelesaikan submateri.',
            ], 404);  // Status code 404 (Not Found)
        }

        // Kirim data progres untuk setiap santri yang sudah selesai latihan
        return response()->json([
            'status' => 'success',
            'data' => $santriProgressData,  // Mengembalikan data progres yang telah diselesaikan
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}




}
