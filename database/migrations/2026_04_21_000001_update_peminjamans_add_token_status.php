<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->string('token')->nullable()->after('status');
            $table->text('catatan_admin')->nullable()->after('token');
        });

        // Update status default ke 'menunggu' tanpa ->change() enum
        // (kompatibel dengan MySQL & PostgreSQL)
        DB::statement("UPDATE peminjamans SET status = 'menunggu' WHERE status NOT IN ('menunggu','disetujui','ditolak','dipinjam','dikembalikan')");
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['token', 'catatan_admin']);
        });
    }
};
