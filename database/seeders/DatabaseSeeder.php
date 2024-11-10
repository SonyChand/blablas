<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
            ['name' => 'recomendation_letter-list', 'description' => 'Melihat data Surat Rekomendasi'],
            ['name' => 'recomendation_letter-create', 'description' => 'Menambah data Surat Rekomendasi'],
            ['name' => 'recomendation_letter-edit', 'description' => 'Mengubah data Surat Rekomendasi'],
            ['name' => 'recomendation_letter-delete', 'description' => 'Menghapus data Surat Rekomendasi'],
            ['name' => 'recomendation_letter-download', 'description' => 'Mengunduh data Surat Rekomendasi'],
            ['name' => 'official_task_file_letter-list', 'description' => 'Melihat data Surat Tugas Resmi'],
            ['name' => 'official_task_file_letter-create', 'description' => 'Menambah data Surat Tugas Resmi'],
            ['name' => 'official_task_file_letter-edit', 'description' => 'Mengubah data Surat Tugas Resmi'],
            ['name' => 'official_task_file_letter-delete', 'description' => 'Menghapus data Surat Tugas Resmi'],
            ['name' => 'official_task_file_letter-download', 'description' => 'Mengunduh data Surat Tugas Resmi'],
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
    }
}
