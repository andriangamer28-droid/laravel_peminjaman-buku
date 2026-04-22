<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;

class ToolSeeder extends Seeder
{
    public function run()
    {
        // Menambah data alat secara otomatis ke database
        Tool::create([
            'nama_alat' => 'Solder Listrik',
            'deskripsi' => 'Alat patri komponen elektronika',
            'stok' => 50
        ]);

        Tool::create([
            'nama_alat' => 'Multimeter Digital',
            'deskripsi' => 'Pengukur arus dan tegangan',
            'stok' => 30
        ]);
    }
}