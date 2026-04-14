<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('admins')->insert([
            'username'   => 'admin',
            'password'   => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kategori — sesuaikan dengan data aslimu
        $kategoris = [
            'Kebersihan',
            'Kerusakan Fasilitas',
            'Keamanan',
            'Sanitasi & Air',
            'Listrik',
            'Lainnya',
        ];

        foreach($kategoris as $kat){
            DB::table('kategoris')->insert([
                'ket_kategori' => $kat,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // Siswa — sesuaikan dengan data aslimu
        $siswas = [
            ['nis' => 1001, 'kelas' => 'X-RPL-1'],
            ['nis' => 1002, 'kelas' => 'X-RPL-2'],
        ];

        foreach($siswas as $s){
            DB::table('siswas')->insert([
                'nis'        => $s['nis'],
                'kelas'      => $s['kelas'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}