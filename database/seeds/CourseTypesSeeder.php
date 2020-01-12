<?php

use App\CourseType;
use Illuminate\Database\Seeder;

class CourseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseType::create([
            'wsdl_id' => 1,
            'name' => 'first-aid-basic-course_ta',
            'slug' => 'bg-gk',
            'group' => 'first-aid-courses',
        ]);

        CourseType::create([
            'wsdl_id' => 2,
            'name' => 'first-aid-training_ta',
            'slug' => 'bg-fb',
            'group' => 'first-aid-courses',
        ]);

        CourseType::create([
            'wsdl_id' => 8,
            'name' => 'first_aid_training_in_educational_and_care_facilities_for_children_ta',
            'slug' => 'bg-bbek',
            'group' => 'first-aid-courses',
        ]);

        CourseType::create([
            'wsdl_id' => 3,
            'name' => 'company_paramedic-basic-course_ta',
            'slug' => 'bs-gl',
            'group' => 'company_paramedic',
        ]);

        CourseType::create([
            'wsdl_id' => 4,
            'name' => 'company_paramedic-advanced-training-course_ta',
            'slug' => 'bs-al',
            'group' => 'company_paramedic',
        ]);

        CourseType::create([
            'wsdl_id' => 5,
            'name' => 'company_paramedic-training_ta',
            'slug' => 'bs-fb',
            'group' => 'company_paramedic',
        ]);

        CourseType::create([
            'wsdl_id' => 6,
            'name' => 'first-aid-teacher-training_ta',
            'slug' => 'eh-lka',
            'group' => 'teachers',
        ]);

        CourseType::create([
            'wsdl_id' => 7,
            'name' => 'first-aid-teacher-advanced-training_ta',
            'slug' => 'eh-lkf',
            'group' => 'teachers',
        ]);
    }
}
