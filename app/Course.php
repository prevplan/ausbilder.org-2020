<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Course extends Model
{
    use HasHashid, HashidRouting;

    protected $fillable = [
        'company_id', 'type', 'internal_number', 'registration_number', 'registered', 'seminar_location', 'street', 'zipcode', 'location', 'start', 'end', 'responsible',
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

    public function responsibility()
    {
        return $this->belongsTo('App\User', 'responsible');
    }
}
