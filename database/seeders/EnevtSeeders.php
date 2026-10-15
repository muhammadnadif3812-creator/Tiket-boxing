<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EnevtSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'Event cosplay anime',
                'category' => 'Festival',
                'ticket_price' => 15000,
                'description' => 'Festival budaya anime jepang',
                'image' => null,
                'created_at' => now(),
                'updated_at'=> now(),
            ],
            [
                'title' => 'Event konser Gold play',
                'category' => 'Musik',
                'ticket_price' => 200000,
                'description' => 'Konser musuk artis dunia',
                'image' => null,
                'created_at' => now(),
                'updated_at'=> now(),
            ],
            [
                'title' => 'Semiar Hacking',
                'category' => 'Seminar',
                'ticket_price' => 200000,
                'description' => 'belajar jadi caybersecurity',
                'image' => null,
                'created_at' => now(),
                'updated_at'=> now(),
            ],
            [
                'title' => 'Fesival makanan Nusantara',
                'category' => 'Festival',
                'ticket_price' => 200000,
                'description' => 'Festival mengenalkan makanan indonesia dimata dunia',
                'image' => null,
                'created_at' => now(),
                'updated_at'=> now(),
            ],
            [
                'title' => 'Fesival Baitk Nasional',
                'category' => 'Festival',
                'ticket_price' => 200000,
                'description' => 'Festival Menggunakan pakaian Batik indonesia',
                'image' => null,
                'created_at' => now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
