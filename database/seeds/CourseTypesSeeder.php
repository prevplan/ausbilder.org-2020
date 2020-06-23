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
            'name' => 'first aid basic course (TA)',
            'slug' => 'bg-gk',
            'group' => 'first aid courses',
            'lessons' => 9,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'wsdl_id' => 2,
            'name' => 'first aid training (TA)',
            'slug' => 'bg-fb',
            'group' => 'first aid courses',
            'lessons' => 9,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'wsdl_id' => 8,
            'name' => 'first aid training in educational and care facilities for children (TA)',
            'slug' => 'bg-bbek',
            'group' => 'first aid courses',
            'lessons' => 9,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'wsdl_id' => 3,
            'name' => 'company_paramedic-basic-course_ta',
            'slug' => 'bs-gl',
            'group' => 'company_paramedic',
            'lessons' => 63,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'wsdl_id' => 4,
            'name' => 'company_paramedic-advanced-training-course_ta',
            'slug' => 'bs-al',
            'group' => 'company_paramedic',
            'lessons' => 32,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'wsdl_id' => 5,
            'name' => 'company_paramedic-training_ta',
            'slug' => 'bs-fb',
            'group' => 'company_paramedic',
            'lessons' => 16,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'wsdl_id' => 6,
            'name' => 'first aid teacher training (TA)',
            'slug' => 'eh-lka',
            'group' => 'teachers',
            'lessons' => 56,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'wsdl_id' => 7,
            'name' => 'first aid teacher advanced training (TA)',
            'slug' => 'eh-lkf',
            'group' => 'teachers',
            'lessons' => 16,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);

        CourseType::create([
            'name' => 'first aid course (§ 19 FeV)',
            'slug' => 'fa-fev',
            'group' => 'first aid courses',
            'lessons' => 9,
            'lessons_per_day' => 9,
            'seats' => 20,
        ]);
    }
}
