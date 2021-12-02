<?php

namespace Database\Seeders;

use App\Models\Approval;
use App\Models\ApprovalStatus;
use App\Models\Attende;
use App\Models\AttendeStatus;
use App\Models\AttendeType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GenderSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            AttendeTypeSeeder::class,
            AttendeStatusSeeder::class,
            AttendeSeeder::class,
            PermissionTypeSeeder::class,
            PermissionStatusSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
