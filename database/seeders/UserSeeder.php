<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Mockery\Generator\StringManipulation\Pass\Pass;

class UserSeeder extends Seeder
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
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'gender_id' => 1,
                'department_id' => 1,
            ],
            [
                'name' => 'Employee',
                'email' => 'employee@gmail.com',
                'password' => bcrypt('12345678'),
                'gender_id' => 1,
                'department_id' => 2,
            ],
            [
                'name' => 'HRD',
                'email' => 'hrd@gmail.com',
                'password' => bcrypt('12345678'),
                'gender_id' => 1,
                'department_id' => 3,
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => bcrypt('12345678'),
                'gender_id' => 1,
                'department_id' => 4,
            ],
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
