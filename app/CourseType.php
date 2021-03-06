<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseType extends Model
{
    use HasHashid, HashidRouting;

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
