<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Market;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Pasar Baru',
                'address' => 'godean, sleman, yogyakarta',
            ],
            [
                'name' => 'Pasar Gede',
                'address' => 'banguntapan, bantul, yogyakarta',
            ],
            [
                'name' => 'Pasar Pathuk',
                'address' => 'pathuk, gunung kidul, yogyakarta',
            ],
        ];
        Market::insert($data);
    }
}
