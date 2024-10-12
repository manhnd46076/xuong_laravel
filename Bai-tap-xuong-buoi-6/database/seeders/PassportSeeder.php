<?php

namespace Database\Seeders;

use App\Models\Passport;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentIDs = Student::pluck('id')->all();

        foreach ($studentIDs as $studentID) {
            Passport::query()->create([
                'student_id' => $studentID,
                'passport_number' =>fake()->bothify('#######'),
                'issued_date' => '2020-1-10',
                'expiry_date' => '2023-1-10'

            ]);
        }
    }
}
