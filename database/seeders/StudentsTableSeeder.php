<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 60; $i++) {
            $student = new Student([
                'enrollment_no' => 230283116001 + $i,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'middle_name' => $faker->firstNameMale,
                'email' => 230283116001 + $i . '@ldce.ac.in',
                'phone_number' => $faker->phoneNumber,
                'department_id' => 1, // Adjust range as needed
                'admission_year' => 2022,
                'student_type' => 1,
                'division_id' => 1, // Adjust range as needed
                'temporary_id' => $faker->randomNumber(4),
                'password' => Hash::make('1'),
            ]);

            $student->save();
        }
    }
}
