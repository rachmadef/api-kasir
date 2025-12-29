<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function __construct(protected UserService $users) {}

    public function index()
    {
        $data = $this->users->getByRole('Karyawan');

        return response()->json([
            'status' => true,
            'message' => 'Daftar karyawan',
            'data' => $data
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required',
            'email'     => 'required|email|unique:user,email',
            'password'  => 'required|min:6',
            'no_telp'   => 'nullable'
        ]);

        $data = $request->all();
        $data['role']   = 'Karyawan';
        $data['status'] = 'Aktif';

        $user = $this->users->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Karyawan berhasil ditambahkan',
            'data' => $user
        ]);
    }


    public function show($id)
    {
        $user = $this->users->findKaryawan($id);

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        return $user;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'sometimes|required',
            'email'    => 'sometimes|required|email',
            'status'   => 'sometimes|in:Aktif,Cuti,Nonaktif',
            'password' => 'nullable|min:6'
        ]);

        $user = $this->users->updateKaryawan($id, $request->all());

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Karyawan berhasil diperbarui',
            'data' => $user
        ]);
        dd($request->all());

    }

    public function destroy($id)
    {
        $deleted = $this->users->deleteKaryawan($id);

        if (! $deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Karyawan berhasil dihapus'
        ]);
    }
}