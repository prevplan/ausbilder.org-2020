<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Invitation extends Model
{
    use HasHashid, HashidRouting;

    protected $fillable = ['company_id', 'email', 'invited_by', 'code'];
}
