<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'company_id', 'type', 'internal_number', 'registration_number', 'registered', 'seminar_location', 'street', 'zipcode', 'location', 'start', 'end',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('company_active', 'user_active')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsToMany(User::class)->withPivot('position_id')->withTimestamps();
    }

    public function course_types()
    {
        return $this->hasMany(CourseType::class, 'id', 'type');
    }
}
