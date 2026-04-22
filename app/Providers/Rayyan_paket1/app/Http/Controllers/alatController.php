<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat; // Pastikan model Alat di-import

class AlatController extends Controller
{
    // 1. Menampilkan daftar alat
    public function index()
    {
        // Mengambil semua data dari yang terbaru
        $semuaAlat = Alat::latest()->get();
        
        // Menghitung total untuk statistik di dashboard
        $totalAlat = $semuaAlat->count();
        $kondisiBagus = $semuaAlat->count(); // Sementara disamakan

        return view('alat.index', compact('semuaAlat', 'totalAlat', 'kondisiBagus'));
    }

    // 2. Menampilkan form tambah alat
    public function create()
    {
        return view('alat.create');
    }

    // 3. Menyimpan data alat baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_alat' => 'required',
            'kategori' => 'required',
        ]);

        // Simpan ke database
        Alat::create($request->all());

        // Kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan!');
    }
}