<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionStatus;

class PermissionStatusSeeder extends Seeder
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
                'name' => 'Disetujui',
                'description' => 'Pengajuan anda memenuhi syarat dan telah disetujui'
            ],
            [
                'name' => 'Menunggu Persetujuan',
                'description' => 'Pengajuan anda diterima dan menunggu persetujuan'
            ],
            [
                'name' => 'Ditolak',
                'description' => 'Pengajuan anda ditolak karena tidak memenuhi ketentuan!'
            ],
        ];

        foreach ($data as $item) {
            PermissionStatus::create($item);
        }
    }
}
