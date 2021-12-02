<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\AttendeStatus;
use Illuminate\Database\Seeder;

class AttendeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Tepat Waktu',
            'Terlambat',
            'Tidak Valid',
        ];

        foreach ($data as $status) {
            AttendeStatus::create(
                [
                    'name' => $status,
                    'slug' => Str::slug($status)
                ]
            );
        }
    }
}
