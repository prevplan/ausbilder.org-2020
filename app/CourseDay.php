<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseDay extends Model
{
    use HasHashid, HashidRouting;

    protected $fillable = ['course_id', 'start_id', 'startDay', 'startReal', 'end_id', 'endDay', 'endReal', 'lessonsDay', 'code'];
}
