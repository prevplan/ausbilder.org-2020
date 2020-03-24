<?php

namespace App;

use Laratrust\Models\LaratrustRole;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Role extends LaratrustRole
{
    use HasHashid, HashidRouting;
}
