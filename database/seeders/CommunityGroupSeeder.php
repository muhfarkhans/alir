<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommunityGroup;

class CommunityGroupSeeder extends Seeder
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
                'market_id' => 1,
                'name' => 'kelompok 1',
                'address' => 'pasar baru,sleman, yogyakarta',
            ],
            [
                'market_id' => 1,
                'name' => 'kelompok 2',
                'address' => 'pasar gede,bantul, yogyakarta',
            ],
            [
                'market_id' => 3,
                'name' => 'kelompok 3',
                'address' => 'pasar wonosari,gunung kidul, yogyakarta',
            ],
        ];
        CommunityGroup::insert($data);
    }
}
