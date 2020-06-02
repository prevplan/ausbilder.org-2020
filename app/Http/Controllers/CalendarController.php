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

namespace App\Http\Controllers;

use App\Company;
use App\Course;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Vinkla\Hashids\Facades\Hashids;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $parameter
     * @return \Illuminate\Http\Response
     */
    public function index($parameter)
    {
        $parameter = explode('-', $parameter);

        // Split first param in hashed user & company ID
        $id = str_split($parameter[0], env('HASHID_LENGTH'));

        $user_id = Hashids::decode($id[0]);
        $company_id = Hashids::decode($id[1]);
        $company_id = $company_id[0];

        $company = Company::FindOrFail($company_id);

        // get the user
        $user = User::FindOrFail($user_id);
        $user = $user[0];

        // check the api code
        abort_unless($user['api_code'] == $parameter[1], 403);

        $active = $company->users()
            ->wherePivot('user_id', $user->id)
            ->wherePivot('company_active', 1)
            ->wherePivot('user_active', 1)
            ->first();

        // check that user is a active company member
        abort_unless($active, 403);

        // TODO don't reuse code from CompanyController
        if (count($parameter) == 3) {
            if ($parameter[2] == 'own') { // show only own courses
                $course = DB::table('course_user')
                    ->where('user_id', $user->id)
                    ->get();

                $courses = Course::whereIn('id', $course->pluck('course_id'))
                    ->where('company_id', $company_id)
                    ->with('course_types')
                    ->with('responsibility')
                    ->orderBy('start', 'desc')
                    ->get();
            } else {
                abort(403);
            }
        } elseif ($user->isAbleTo('course.view', $company_id)) {
            $courses = Course::where([
                ['company_id', $company_id],
            ])
                ->with('course_types')
                ->with('user')
                ->orderBy('start', 'desc')
                ->get();
        } else { // show only own courses
            $course = DB::table('course_user')
                ->where('user_id', $user->id)
                ->get();

            $courses = Course::whereIn('id', $course->pluck('course_id'))
                ->where('company_id', $company_id)
                ->orWhere(function ($query) use ($company_id, $user) {
                    $query->where('responsible', $user->id)
                        ->where('company_id', $company_id);
                })
                ->with('course_types')
                ->with('responsibility')
                ->orderBy('start', 'desc')
                ->get();
        }

        $event = [];

        foreach ($courses as $course) {
            $event[] = Event::create()
                ->name(__($course['course_types'][0]['name']))
                ->address($course->street.', '.$course->zipcode.' '.$course->location)
                ->addressName($course->seminar_location)
                ->description(route('course.show', ['course' => $course]))
                ->uniqueIdentifier($course->internal_number)
                ->createdAt($course->created_at)
                ->startsAt(Carbon::CreateFromDate($course->start))
                ->endsAt(Carbon::CreateFromDate($course->end));
        }

        $calendar = Calendar::create($company->name.' '.__('courses'))
            ->description(__('course calendar by ausbilder.org'))
            ->refreshInterval(5)
            ->withTimezone()
            ->event(
                $event
            );

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar')
            ->header('charset', 'utf-8');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
