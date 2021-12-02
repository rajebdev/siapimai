<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\PermissionType;
use Illuminate\Database\Seeder;

class PermissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Sakit',
            'Cuti'
        ];

        foreach ($data as $type) {
            PermissionType::create(
                [
                    'name' => $type,
                    'slug' => Str::slug($type)
                ]
            );
        }
    }
}
