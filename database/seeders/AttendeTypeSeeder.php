<?php

namespace Database\Seeders;

use App\Models\AttendeType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AttendeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Absen Masuk',
            'Absen Keluar'
        ];

        foreach ($data as $type) {
            AttendeType::create(
                [
                    'name' => $type,
                    'slug' => Str::slug($type)
                ]
            );
        }
    }
}
