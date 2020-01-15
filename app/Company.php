<?php

namespace App;

use Laratrust\Models\LaratrustTeam;

class Company extends LaratrustTeam
{
    protected $fillable = ['name', 'name_suffix', 'street', 'zipcode', 'location'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('company_active', 'user_active')->withTimestamps();
    }

    public function course_types()
    {
        return $this->belongsToMany(CourseType::class)->withTimestamps();
    }
}
