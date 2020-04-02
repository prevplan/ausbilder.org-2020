<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Signature extends Model
{
    use HasHashid, HashidRouting;

    protected $fillable = ['course_id', 'participant_id', 'courseDay_id', 'sign'];
}
