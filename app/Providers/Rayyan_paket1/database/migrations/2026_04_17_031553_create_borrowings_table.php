<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi UP untuk MEMBUAT tabel
   public function up(): void
{
    Schema::create('borrowings', function (Blueprint $table) {
        $table->id();
        $table->string('member_name'); // Menggunakan teks langsung
        $table->string('book_title');  // Menggunakan teks langsung
        $table->date('borrow_date');
        $table->date('return_date');
        $table->string('status')->default('borrowed');
        $table->timestamps();
    });
}

    // Fungsi DOWN untuk MENGHAPUS tabel jika ada kesalahan
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
}; // <--- Pastikan ada titik koma di sini