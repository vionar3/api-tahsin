<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        // Ambil data user yang memiliki peran 'santri'
        $users = User::where('peran', 'santri')->get();

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


//     public function importSantri(Request $request)
// {
//     // Validasi input
//     $validator = Validator::make($request->all(), [
//         'santri' => 'required|array',
//         'santri.*.nama_lengkap' => 'required|string|max:255',
//         'santri.*.alamat' => 'required|string|max:255',
//         'santri.*.usia' => 'required|string|max:255',
//         'santri.*.no_telp_wali' => 'required|string|max:20',
//         'santri.*.email' => 'required|email|max:255',
//         'santri.*.jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
//         'santri.*.jenjang_pendidikan' => 'required|string|max:255',
//     ]);

//     // Jika validasi gagal
//     if ($validator->fails()) {
//         return ResponseFormatter::error(
//             null,
//             'Validation Error',
//             422
//         );
//     }

//     // Ambil data santri dari request
//     $santriData = $request->input('santri');
//     $santriInserted = [];

//     // Simpan tiap santri ke database
//     foreach ($santriData as $santri) {
//         $santriInserted[] = User::create([
//             'nama_lengkap' => $santri['nama_lengkap'],
//             'alamat' => $santri['alamat'],
//             'usia' => $santri['usia'],
//             'no_telp_wali' => $santri['no_telp_wali'],
//             'email' => $santri['email'],
//             'jenis_kelamin' => $santri['jenis_kelamin'],
//             'jenjang_pendidikan' => $santri['jenjang_pendidikan'],
//             'peran' => 'santri',
//             'password' => bcrypt($santri['email']), // password = email (dihash)
//         ]);
//     }

//     // Respon sukses
//     return ResponseFormatter::success(
//         $santriInserted,
//         'Santri data imported successfully'
//     );
// }


}
