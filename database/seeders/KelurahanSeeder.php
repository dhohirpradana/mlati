<?php

namespace Database\Seeders;

use App\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kelurahan::create([
            'nama_kelurahan'     => 'Mlati Norowito',
            'nama_kecamatan'     => 'Kota Kudus',
            'nama_kabupaten'     => 'Kudus',
            'alamat'             => 'Mlati Norowito, No. 35, RT. 03 RW. 05, Mlati Norowito, Kec. Kota Kudus, Kabupaten Kudus, Jawa Tengah 59319',
            'nama_lurah'   => "Nama Kades Mlati Norowito",
            'alamat_lurah' => "Alamat Kades Mlati Norowito",
            'logo'               => "logo.png",
        ]);
    }
}
