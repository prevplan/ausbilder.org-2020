<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'name_suffix', 'street', 'zipcode', 'location'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
