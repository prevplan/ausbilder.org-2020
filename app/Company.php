<?php

/**
 * ausbilder.org - the free course management and planning software.
 * Copyright (C) 2020 Holger Schmermbeck & others (see the AUTHORS file).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App;

use Laratrust\Models\LaratrustTeam;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Company extends LaratrustTeam
{
    use HasHashid, HashidRouting;

    protected $fillable = ['name', 'name_suffix', 'street', 'zipcode', 'location', 'doctor', 'reference', 'qseh_password',
        'terms', 'cpolicy', 'dataprotection', 'email', ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('company_active', 'user_active')->withTimestamps();
    }

    public function course_types()
    {
        return $this->belongsToMany(CourseType::class)->withTimestamps();
    }
}
