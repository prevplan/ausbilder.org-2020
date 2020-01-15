<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['company_id', 'email', 'invited_by', 'code'];
}
