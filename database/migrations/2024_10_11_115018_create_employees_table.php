<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // ID Karyawan
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('user_id')->nullable(); // ID User
            $table->string('email')->unique(); // Nama Lengkap
            $table->string('name'); // Nama Lengkap
            $table->enum('employee_type', ['PNS', 'PPPK']); // Jenis Pegawai
            $table->string('employee_identification_number')->unique(); // Nomor Induk Pegawai (NIP)
            $table->string('birth_place'); // Tempat Lahir
            $table->date('birth_date'); // Tanggal Lahir
            $table->date('rank_start_date'); // Tanggal Mulai Pangkat
            $table->string('rank')->nullable(); // Pangkat/Golongan
            $table->date('position_start_date'); // Tanggal Mulai Jabatan
            $table->string('position')->nullable(); // Jabatan
            $table->enum('education_level', [
                'Tidak Sekolah',
                'SD',
                'SMP',
                'SMA',
                'Diploma 3',
                'Diploma 4 / Sarjana',
                'Magister',
                'Doktor',
                'Profesional'
            ])->nullable(); // Pendidikan Terakhir
            $table->string('education_institution')->nullable(); // Nama Perguruan Tinggi
            $table->string('major')->nullable(); // Jurusan
            $table->date('graduation_date')->nullable(); // Tanggal Lulus
            $table->string('work_unit')->nullable(); // Unit Kerja
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
