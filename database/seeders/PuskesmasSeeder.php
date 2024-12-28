<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\SPM\Puskesmas;

class PuskesmasSeeder extends Seeder
{
    public function run()
    {
        $puskesmasData = [
            ['kode' => 'P3207100101', 'nama' => 'Puskesmas Banjarsari', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207100202', 'nama' => 'Puskesmas Ciulu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207100203', 'nama' => 'Puskesmas Cigayam', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207110101', 'nama' => 'Puskesmas Lakbok', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207110202', 'nama' => 'Puskesmas Sidaharja', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207111201', 'nama' => 'Puskesmas Purwadadi', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207120201', 'nama' => 'Puskesmas Pamarican', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207120202', 'nama' => 'Puskesmas Kertahayu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207130201', 'nama' => 'Puskesmas Cidolog', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207140101', 'nama' => 'Puskesmas Cimaragas', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207150201', 'nama' => 'Puskesmas Cijeungjing', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207150202', 'nama' => 'Puskesmas Handapherang', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207160201', 'nama' => 'Puskesmas Cisaga', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207170201', 'nama' => 'Puskesmas Tambaksari', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207180101', 'nama' => 'Puskesmas Rancah', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207190201', 'nama' => 'Puskesmas Rajadesa', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207220202', 'nama' => 'Puskesmas Cikoneng', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207210201', 'nama' => 'Puskesmas Ciamis', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207210202', 'nama' => 'Puskesmas Imbanagara', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207211201', 'nama' => 'Puskesmas Baregbeg', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207220201', 'nama' => 'Puskesmas Sindangkasih', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207200201', 'nama' => 'Puskesmas Sukadana', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207230201', 'nama' => 'Puskesmas Cihaurbeu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207230202', 'nama' => 'Puskesmas Sukamulya', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207240201', 'nama' => 'Puskesmas Sadananya', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207250101', 'nama' => 'Puskesmas Cipaku', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207250202', 'nama' => 'Puskesmas Cieurih', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207260201', 'nama' => 'Puskesmas Jatinagara', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207270101', 'nama' => 'Puskesmas Gardujaya', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207270202', 'nama' => 'Puskesmas Panawangan', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207280101', 'nama' => 'Puskesmas Kawali', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207280202', 'nama' => 'Puskesmas Lumbung', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207280203', 'nama' => 'Puskesmas Kawalimukti', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207290101', 'nama' => 'Puskesmas Panjalu', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207291101', 'nama' => 'Puskesmas Sukamantri', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207300101', 'nama' => 'Puskesmas Panumbangan', 'alamat' => 'Ciamis'],
            ['kode' => 'P3207300202', 'nama' => 'Puskesmas Payungsari', 'alamat' => 'Ciamis'],
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
