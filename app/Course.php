<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'company_id', 'type', 'seminar_location', 'street', 'zipcode', 'location', 'start', 'end'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('company_active', 'user_active')->withTimestamps();
    }
}
