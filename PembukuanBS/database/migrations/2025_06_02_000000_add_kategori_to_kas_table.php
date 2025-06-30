<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('aksi');
            $table->index(['tanggal', 'nasabah_id', 'kategori']); // Add index for search optimization
        });
    }

    public function down()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropIndex(['tanggal', 'nasabah_id', 'kategori']);
            $table->dropColumn('kategori');
        });
    }
};
