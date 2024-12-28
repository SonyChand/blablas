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
        Schema::create('tahuns', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->timestamps();
        });
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->string('nama');
            $table->string('alamat');
            $table->timestamps();
        });
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 1)->unique();
            $table->string('nama')->unique();
            $table->timestamps();
        });
        Schema::create('sub_layanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layanan_id');
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('cascade');
            $table->string('kode');
            $table->string('uraian');
            $table->string('satuan');
            $table->timestamps();
        });
        Schema::create('spms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('puskesmas_id');
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas')->onDelete('cascade');
            $table->unsignedBigInteger('sub_layanan_id');
            $table->foreign('sub_layanan_id')->references('id')->on('sub_layanans')->onDelete('cascade');
            $table->unsignedBigInteger('tahun_id');
            $table->foreign('tahun_id')->references('id')->on('tahuns')->onDelete('cascade');
            $table->integer('dilayani')->nullable();
            $table->integer('terlayani')->nullable();
            $table->integer('belum_terlayani')->nullable();
            $table->decimal('pencapaian', 5, 2)->nullable();
            $table->integer('bulan');
            $table->timestamps();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('spm_total', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spm_id');
            $table->foreign('spm_id')->references('id')->on('spms')->onDelete('cascade');
            $table->integer('total_dilayani')->nullable();
            $table->integer('total_terlayani')->nullable();
            $table->integer('total_belum_terlayani')->nullable();
            $table->decimal('total_pencapaian', 5, 2)->nullable();
            $table->timestamps();
        });



        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('puskesmas_id')->nullable()->after('id'); // Add the column after 'id'
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spms');
        Schema::dropIfExists('sub_layanans');
        Schema::dropIfExists('layanans');
        Schema::dropIfExists('puskesmas');
        Schema::dropIfExists('tahuns');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['puskesmas_id']); // Drop the foreign key constraint
            $table->dropColumn('puskesmas_id'); // Drop the column
        });
    }
};
