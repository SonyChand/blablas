<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\SpmSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\TahunSeeder;
use Database\Seeders\MasterSeeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\LayananSeeder;
use Database\Seeders\PuskesmasSeeder;
use Database\Seeders\SubLayananSeeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'role-list', 'description' => 'Melihat data Peran'],
            ['name' => 'role-create', 'description' => 'Menambah data Peran'],
            ['name' => 'role-edit', 'description' => 'Mengubah data Peran'],
            ['name' => 'role-delete', 'description' => 'Menghapus data Peran'],
            ['name' => 'role-download', 'description' => 'Mengunduh data Peran'],
            ['name' => 'user-list', 'description' => 'Melihat data Pengguna'],
            ['name' => 'user-create', 'description' => 'Menambah data Pengguna'],
            ['name' => 'user-edit', 'description' => 'Mengubah data Pengguna'],
            ['name' => 'user-delete', 'description' => 'Menghapus data Pengguna'],
            ['name' => 'user-download', 'description' => 'Mengunduh data Pengguna'],
            ['name' => 'incoming_letter-list', 'description' => 'Melihat data Surat Masuk'],
            ['name' => 'incoming_letter-create', 'description' => 'Menambah data Surat Masuk'],
            ['name' => 'incoming_letter-edit', 'description' => 'Mengubah data Surat Masuk'],
            ['name' => 'incoming_letter-delete', 'description' => 'Menghapus data Surat Masuk'],
            ['name' => 'incoming_letter-download', 'description' => 'Mengunduh data Surat Masuk'],
            ['name' => 'outgoing_letter-list', 'description' => 'Melihat data Surat Keluar'],
            ['name' => 'outgoing_letter-create', 'description' => 'Menambah data Surat Keluar'],
            ['name' => 'outgoing_letter-edit', 'description' => 'Mengubah data Surat Keluar'],
            ['name' => 'outgoing_letter-delete', 'description' => 'Menghapus data Surat Keluar'],
            ['name' => 'outgoing_letter-download', 'description' => 'Mengunduh data Surat Keluar'],
            ['name' => 'recommendation-list', 'description' => 'Melihat data Surat Rekomendasi'],
            ['name' => 'recommendation-create', 'description' => 'Menambah data Surat Rekomendasi'],
            ['name' => 'recommendation-edit', 'description' => 'Mengubah data Surat Rekomendasi'],
            ['name' => 'recommendation-delete', 'description' => 'Menghapus data Surat Rekomendasi'],
            ['name' => 'recommendation-download', 'description' => 'Mengunduh data Surat Rekomendasi'],
            ['name' => 'official_task_file-list', 'description' => 'Melihat data Surat Tugas Resmi'],
            ['name' => 'official_task_file-create', 'description' => 'Menambah data Surat Tugas Resmi'],
            ['name' => 'official_task_file-edit', 'description' => 'Mengubah data Surat Tugas Resmi'],
            ['name' => 'official_task_file-delete', 'description' => 'Menghapus data Surat Tugas Resmi'],
            ['name' => 'official_task_file-download', 'description' => 'Mengunduh data Surat Tugas Resmi'],
            ['name' => 'command_letter-list', 'description' => 'Melihat data Surat Perintah'],
            ['name' => 'command_letter-create', 'description' => 'Menambah data Surat Perintah'],
            ['name' => 'command_letter-edit', 'description' => 'Mengubah data Surat Perintah'],
            ['name' => 'command_letter-delete', 'description' => 'Menghapus data Surat Perintah'],
            ['name' => 'command_letter-download', 'description' => 'Mengunduh data Surat Perintah'],
            ['name' => 'spdd-list', 'description' => 'Melihat data SPDD'],
            ['name' => 'spdd-create', 'description' => 'Menambah data SPDD'],
            ['name' => 'spdd-edit', 'description' => 'Mengubah data SPDD'],
            ['name' => 'spdd-delete', 'description' => 'Menghapus data SPDD'],
            ['name' => 'spdd-download', 'description' => 'Mengunduh data SPDD'],
            ['name' => 'delivery_note-list', 'description' => 'Melihat data Surat Pengantar'],
            ['name' => 'delivery_note-create', 'description' => 'Menambah data Surat Pengantar'],
            ['name' => 'delivery_note-edit', 'description' => 'Mengubah data Surat Pengantar'],
            ['name' => 'delivery_note-delete', 'description' => 'Menghapus data Surat Pengantar'],
            ['name' => 'delivery_note-download', 'description' => 'Mengunduh data Surat Pengantar'],
            ['name' => 'memo-list', 'description' => 'Melihat data Memo'],
            ['name' => 'memo-create', 'description' => 'Menambah data Memo'],
            ['name' => 'memo-edit', 'description' => 'Mengubah data Memo'],
            ['name' => 'memo-delete', 'description' => 'Menghapus data Memo'],
            ['name' => 'memo-download', 'description' => 'Mengunduh data Memo'],
            ['name' => 'disposition-list', 'description' => 'Melihat data Disposisi'],
            ['name' => 'disposition-create', 'description' => 'Menambah data Disposisi'],
            ['name' => 'disposition-edit', 'description' => 'Mengubah data Disposisi'],
            ['name' => 'disposition-delete', 'description' => 'Menghapus data Disposisi'],
            ['name' => 'disposition-download', 'description' => 'Mengunduh data Disposisi'],
            ['name' => 'employee-list', 'description' => 'Melihat data Pegawai'],
            ['name' => 'employee-create', 'description' => 'Menambah data Pegawai'],
            ['name' => 'employee-edit', 'description' => 'Mengubah data Pegawai'],
            ['name' => 'employee-delete', 'description' => 'Menghapus data Pegawai'],
            ['name' => 'employee-download', 'description' => 'Mengunduh data Pegawai'],
            ['name' => 'master-list', 'description' => 'Melihat data Master'],
            ['name' => 'master-create', 'description' => 'Menambah data Master'],
            ['name' => 'master-edit', 'description' => 'Mengubah data Master'],
            ['name' => 'master-delete', 'description' => 'Menghapus data Master'],
            ['name' => 'master-download', 'description' => 'Mengunduh data Master'],
            ['name' => 'tahun-list', 'description' => 'Melihat data Tahun'],
            ['name' => 'tahun-create', 'description' => 'Menambah data Tahun'],
            ['name' => 'tahun-edit', 'description' => 'Mengubah data Tahun'],
            ['name' => 'tahun-delete', 'description' => 'Menghapus data Tahun'],
            ['name' => 'tahun-download', 'description' => 'Mengunduh data Tahun'],
            ['name' => 'layanan-list', 'description' => 'Melihat data Layanan SPM'],
            ['name' => 'layanan-create', 'description' => 'Menambah data Layanan SPM'],
            ['name' => 'layanan-edit', 'description' => 'Mengubah data Layanan SPM'],
            ['name' => 'layanan-delete', 'description' => 'Menghapus data Layanan SPM'],
            ['name' => 'layanan-download', 'description' => 'Mengunduh data Layanan SPM'],
            ['name' => 'sub-layanan-list', 'description' => 'Melihat data Sub Layanan SPM'],
            ['name' => 'sub-layanan-create', 'description' => 'Menambah data Sub Layanan SPM'],
            ['name' => 'sub-layanan-edit', 'description' => 'Mengubah data Sub Layanan SPM'],
            ['name' => 'sub-layanan-delete', 'description' => 'Menghapus data Sub Layanan SPM'],
            ['name' => 'sub-layanan-download', 'description' => 'Mengunduh data Sub Layanan SPM'],
            ['name' => 'spm-list', 'description' => 'Melihat data SPM Puskesmas sendiri'],
            ['name' => 'spm-edit', 'description' => 'Mengubah data SPM Puskesmas sendiri'],
            ['name' => 'spm-dinkes', 'description' => 'Melihat data SPM Seluruh Puskesmas'],
            ['name' => 'puskesmas-list', 'description' => 'Melihat data Puskesmas'],
            ['name' => 'puskesmas-create', 'description' => 'Menambah data Puskesmas'],
            ['name' => 'puskesmas-edit', 'description' => 'Mengubah data Puskesmas'],
            ['name' => 'puskesmas-delete', 'description' => 'Menghapus data Puskesmas'],
            ['name' => 'puskesmas-download', 'description' => 'Mengunduh data Puskesmas'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'description' => $permission['description']
            ]);
        }

        $user = User::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Lord Daud',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12344321'),
            'email_verified_at' => now(),
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $this->call(MasterSeeder::class);
        $this->call(TahunSeeder::class);
        $this->call(PuskesmasSeeder::class);
        $this->call(LayananSeeder::class);
        $this->call(SubLayananSeeder::class);
        $this->call(SpmSeeder::class);
    }
}
