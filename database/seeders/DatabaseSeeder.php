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


        $this->call(MasterSeeder::class);
        $this->call(TahunSeeder::class);
        $this->call(PuskesmasSeeder::class);
        $this->call(LayananSeeder::class);
        $this->call(SubLayananSeeder::class);
        $this->call(SpmSeeder::class);

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
            ['name' => 'spm-list', 'description' => 'Melihat data SPM Puskesmas sendiri'],
            ['name' => 'spm-edit', 'description' => 'Mengubah data SPM Puskesmas sendiri'],
            ['name' => 'spm-dinkes', 'description' => 'Melihat data SPM Seluruh Puskesmas'],
            ['name' => 'master-spm-list', 'description' => 'Melihat data Master SPM'],
            ['name' => 'master-spm-create', 'description' => 'Menambah data Master SPM'],
            ['name' => 'master-spm-edit', 'description' => 'Mengubah data Master SPM'],
            ['name' => 'master-spm-delete', 'description' => 'Menghapus data Master SPM'],
            ['name' => 'master-spm-download', 'description' => 'Mengunduh data Master SPM'],
        ];


        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'description' => $permission['description']
            ]);
        }

        $user = User::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Admin',
            'email' => 'sonychandmaulana@gmail.com',
            'password' => bcrypt('12344321'),
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Operator PKM',
            'email' => 'operator@gmail.com',
            'password' => bcrypt('12344321'),
            'puskesmas_id' => 1,
            'email_verified_at' => now(),
        ]);

        // Create roles
        $role = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Operator SPM Puskesmas']);

        // Get all permissions
        $allPermissions = Permission::pluck('id', 'id')->all();

        // Sync all permissions with the Admin role
        $role->syncPermissions($allPermissions);

        // Sync only 'spm-list' and 'spm-edit' permissions with the Operator SPM Puskesmas role
        $spmPermissions = Permission::whereIn('name', ['spm-list', 'spm-edit'])->pluck('id')->all();
        $role2->syncPermissions($spmPermissions);

        // Assign roles to users
        $user->assignRole([$role->id]);
        $user2->assignRole([$role2->id]);
    }
}
