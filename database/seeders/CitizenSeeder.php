<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Citizen;

class CitizenSeeder extends Seeder
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
                'nik' => '3404081201990001',
                'fullname' => 'jono',
                'address' => 'sleman, yogyakarta',
                'phone' => '0855123485584',
                'is_guarantor' => 0
            ],
            [
                'nik' => '3404081201990002',
                'fullname' => 'joni',
                'address' => 'bantul, yogyakarta',
                'phone' => '0855123485566',
                'is_guarantor' => 1
            ],
            [
                'nik' => '3404081201990003',
                'fullname' => 'gohan',
                'address' => 'gunung kidul, yogyakarta',
                'phone' => '0855123485547',
                'is_guarantor' => 0
            ],
            [
                'nik' => '3404081201990004',
                'fullname' => 'goku',
                'address' => 'kulon progo, yogyakarta',
                'phone' => '0855123485511',
                'is_guarantor' => 1
            ],
        ];
        Citizen::insert($data);
    }
}
