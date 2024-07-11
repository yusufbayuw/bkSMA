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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('angkatan_lulus_id')->default(1)->nullable()->constrained('angkatan_luluses')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_can_choose')->default(true);
            $table->boolean('is_choosed')->default(false); 
            $table->float('nilai',8,2)->nullable();
            $table->string('kelas')->nullable();
            $table->string('program')->nullable();
            $table->integer('ranking')->nullable();
            $table->boolean('eligible')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
