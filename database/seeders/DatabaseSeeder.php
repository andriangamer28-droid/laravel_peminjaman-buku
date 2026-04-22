<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Anggota;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── User: Admin ─────────────────────────────────────────
        User::create([
            'name'     => 'Admin Perpustakaan',
            'email'    => 'admin@perpus.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── User: Anggota (contoh) ───────────────────────────────
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@perpus.com',
            'password' => Hash::make('password'),
            'role'     => 'anggota',
        ]);

        // ── Kategori ────────────────────────────────────────────
        $fiksi    = Kategori::create(['nama' => 'Fiksi',     'deskripsi' => 'Novel, cerpen, dan karya fiksi lainnya']);
        $nonFiksi = Kategori::create(['nama' => 'Non-Fiksi', 'deskripsi' => 'Buku ilmu pengetahuan dan referensi']);
        $tekno    = Kategori::create(['nama' => 'Teknologi',  'deskripsi' => 'Buku seputar pemrograman dan IT']);

        // ── Buku ────────────────────────────────────────────────
        Buku::create([
            'judul'        => 'Laskar Pelangi',
            'penulis'      => 'Andrea Hirata',
            'penerbit'     => 'Bentang Pustaka',
            'tahun_terbit' => 2005,
            'isbn'         => '9789793062792',
            'kategori_id'  => $fiksi->id,
            'stok'         => 3,
        ]);

        Buku::create([
            'judul'        => 'Bumi Manusia',
            'penulis'      => 'Pramoedya Ananta Toer',
            'penerbit'     => 'Hasta Mitra',
            'tahun_terbit' => 1980,
            'isbn'         => '9789799731234',
            'kategori_id'  => $fiksi->id,
            'stok'         => 2,
        ]);

        Buku::create([
            'judul'        => 'Sapiens',
            'penulis'      => 'Yuval Noah Harari',
            'penerbit'     => 'Harvill Secker',
            'tahun_terbit' => 2011,
            'isbn'         => '9780062316097',
            'kategori_id'  => $nonFiksi->id,
            'stok'         => 2,
        ]);

        Buku::create([
            'judul'        => 'Clean Code',
            'penulis'      => 'Robert C. Martin',
            'penerbit'     => 'Prentice Hall',
            'tahun_terbit' => 2008,
            'isbn'         => '9780132350884',
            'kategori_id'  => $tekno->id,
            'stok'         => 2,
        ]);

        // ── Anggota ─────────────────────────────────────────────
        Anggota::create([
            'nama'     => 'Budi Santoso',
            'alamat'   => 'Jl. Merdeka No. 10, Jakarta',
            'telepon'  => '081234567890',
            'email'    => 'budi@example.com',
        ]);

        Anggota::create([
            'nama'     => 'Siti Aminah',
            'alamat'   => 'Jl. Sudirman No. 5, Bandung',
            'telepon'  => '082345678901',
            'email'    => 'siti@example.com',
        ]);
    }
}
