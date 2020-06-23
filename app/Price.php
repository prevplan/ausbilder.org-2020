<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Price extends Model
{
    use HasHashid, HashidRouting;

    protected $fillable = [
        'company_id', 'title', 'description', 'price', 'currency',
    ];
}
