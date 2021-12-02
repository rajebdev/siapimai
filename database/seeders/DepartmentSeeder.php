<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
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
                'name' => 'Admin',
                'slug' => 'admin'
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee'
            ],
            [
                'name' => 'HRD',
                'slug' => 'hrd'
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager'
            ],
        ];

        foreach ($data as $department) {
            Department::create($department);
        }
    }
}
