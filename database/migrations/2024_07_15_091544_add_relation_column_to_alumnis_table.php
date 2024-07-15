<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->foreignId('kampus_pilihan_id')->nullable()->constrained('kampuses')->nullOnDelete();
            $table->foreignId('jurusan_pilihan_id')->nullable()->constrained('jurusans')->nullOnDelete();
            $table->foreignId('kampus_real_id')->nullable()->constrained('kampuses')->nullOnDelete();
            $table->foreignId('jurusan_real_id')->nullable()->constrained('jurusans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->dropColumn('kampus_pilihan_id');
            $table->dropColumn('jurusan_pilihan_id');
            $table->dropColumn('kampus_real_id');
            $table->dropColumn('jurusan_real_id');
        });
    }
};
