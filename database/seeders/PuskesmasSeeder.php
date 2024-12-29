<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\SPM\Puskesmas;

class PuskesmasSeeder extends Seeder
{
    public function run()
    {
        $puskesmasData = [
            ['kode' => 'P3207100101', 'nama' => 'UPT PKM Banjarsari', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207100202', 'nama' => 'UPT PKM Ciulu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207100203', 'nama' => 'UPT PKM Cigayam', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207110101', 'nama' => 'UPT PKM Lakbok', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207110202', 'nama' => 'UPT PKM Sidaharja', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207111201', 'nama' => 'UPT PKM Purwadadi', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207120201', 'nama' => 'UPT PKM Pamarican', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207120202', 'nama' => 'UPT PKM Kertahayu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207130201', 'nama' => 'UPT PKM Cidolog', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207140101', 'nama' => 'UPT PKM Cimaragas', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207150201', 'nama' => 'UPT PKM Cijeungjing', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207150202', 'nama' => 'UPT PKM Handapherang', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207160201', 'nama' => 'UPT PKM Cisaga', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207170201', 'nama' => 'UPT PKM Tambaksari', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207180101', 'nama' => 'UPT PKM Rancah', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207190201', 'nama' => 'UPT PKM Rajadesa', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207220202', 'nama' => 'UPT PKM Cikoneng', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207210201', 'nama' => 'UPT PKM Ciamis', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207210202', 'nama' => 'UPT PKM Imbanagara', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207211201', 'nama' => 'UPT PKM Baregbeg', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207220201', 'nama' => 'UPT PKM Sindangkasih', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207200201', 'nama' => 'UPT PKM Sukadana', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207230201', 'nama' => 'UPT PKM Cihaurbeu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207230202', 'nama' => 'UPT PKM Sukamulya', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207240201', 'nama' => 'UPT PKM Sadananya', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207250101', 'nama' => 'UPT PKM Cipaku', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207250202', 'nama' => 'UPT PKM Cieurih', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207260201', 'nama' => 'UPT PKM Jatinagara', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207270101', 'nama' => 'UPT PKM Gardujaya', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207270202', 'nama' => 'UPT PKM Panawangan', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207280101', 'nama' => 'UPT PKM Kawali', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207280202', 'nama' => 'UPT PKM Lumbung', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207280203', 'nama' => 'UPT PKM Kawalimukti', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207290101', 'nama' => 'UPT PKM Panjalu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207291101', 'nama' => 'UPT PKM Sukamantri', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207300101', 'nama' => 'UPT PKM Panumbangan', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207300202', 'nama' => 'UPT PKM Payungsari', 'alamat' => 'Ciamis'],
            // ['kode' => 'P3207012', 'nama' => 'RSUD Ciamis', 'alamat' => 'Ciamis'],
            // ['kode' => 'P3207045', 'nama' => 'RS Permata Bunda Ciamis', 'alamat' => 'Ciamis'],
            // ['kode' => 'P3207056', 'nama' => 'RS Al-Arif', 'alamat' => 'Ciamis'],
            // ['kode' => 'P3207057', 'nama' => 'RS Dadi Keluarga', 'alamat' => 'Ciamis'],
            // ['kode' => 'P3207060', 'nama' => 'RSUD Kawali', 'alamat' => 'Ciamis'],
            // ['kode' => 'P3207059', 'nama' => 'RS Khusus Bedah RSOP', 'alamat' => 'Ciamis'],
        ];

        foreach ($puskesmasData as $puskesmas) {
            Puskesmas::create($puskesmas);
        }
    }
}
