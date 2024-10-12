<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stdIDs = Student::pluck('id')->all();
        $sjIDs = Subject::pluck('id')->all();

        foreach ($stdIDs as $key => $stdID) {

             $numberOfSubjects = rand(1, 3);
            $randomSubjects = array_rand($sjIDs, $numberOfSubjects);
            
            if (!is_array($randomSubjects)) {
                $randomSubjects = [$randomSubjects];
            }
           
            foreach ($randomSubjects as $randomSub) {
                DB::table('student_subject')->insert([
                    'student_id' => $stdID,
                    'subject_id' => $sjIDs[$randomSub]
                ]);
            }
        }
    }
}
