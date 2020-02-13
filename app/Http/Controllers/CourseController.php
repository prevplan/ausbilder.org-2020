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
use App\CourseType;
use App\Position;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        if (Auth::user()->can('course.view', session('company_id'))) {
            $courses = Course::where(
                'company_id', session('company_id')
            )
                ->with('course_types')
                ->with('user')
                ->orderBy('start', 'asc')
                ->get();
        } else { // show only own courses
            $course = DB::table('course_user')
                ->where('user_id', Auth::user()->id)
                ->get();

            $courses = Course::whereIn('id', $course->pluck('course_id'))
                ->where('company_id', session('company_id'))
                ->with('course_types')
                ->orderBy('start', 'asc')
                ->get();
        }

        return view('course.index', compact('courses'));

        return $courses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        abort_unless(Auth::user()->can('course.add', session('company_id')), 403);

        $company = Company::where([
            ['id', session('company_id')],
        ])
            ->with('course_types')
            ->first();

        $types = $company->course_types->groupBy('group');

        $positions = Position::where('company_id', 0)
            ->orWhere('company_id', session('company_id'))
            ->get();

        return view('course.create', compact(['company', 'types', 'positions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return string
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        abort_unless(Auth::user()->can('course.add', session('company_id')), 403);

        $this->validate($request, [
            'type' => 'required|integer',
            'start_date' => 'required|date|after_or_equal:'.Carbon::now()->StartOfDay(),
            'start_time' => 'required|date_format:"H:i"',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:"H:i"',
            'seminar_location' => 'required|min:3',
            'street' => 'required|min:3',
            'zipcode' => 'required',
            'location' => 'required|min:3',
        ]);

        if (strtotime($request->start_date) >= strtotime($request->end_date)) { // if end is equal or before end
            if (strtotime($request->start_time) > strtotime($request->end_time)) { // check time
                return back()->withErrors(
                    [
                        'message' => __('check course duration!'),
                    ]
                )
                    ->withInput($request->all);
            }
            $request->end_date = $request->start_date; // correct date
        }

        if (count($request->trainer) != count(array_unique($request->trainer))) {
            return back()->withErrors(
                [
                    'message' => __('a trainer can have only one position per course'),
                ]
            )
                ->withInput($request->all);
        }

        $start = $request->start_date.' '.$request->start_time.':00';
        $end = $request->end_date.' '.$request->end_time.':00';

        $course = Course::create([
            'company_id' => session('company_id'),
            'type' => $request->type,
            'seminar_location' => $request->seminar_location,
            'street' => $request->street,
            'zipcode' => $request->zipcode,
            'location' => $request->location,
            'start' => $start,
            'end' => $end,
        ]);

        $i = 0;

        foreach ($request->trainer as $trainer) {
            $course->users()->attach([$trainer => ['position_id' => $request->position[$i]]]);
            $i++;
        }

        return redirect()->route('course.show', ['course' => $course]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Course  $course
     * @return Factory|View
     */
    public function show(Course $course)
    {
        if (! Auth::user()->can('course.view', session('company_id'))) { //  is not allowed to view courses
            $user_in = false;
            foreach ($course->user as $user) {
                if ($user->id == Auth::user()->id) {
                    $user_in = true;
                }

                abort_unless($user_in, 403); // abort if actual user is no trainer in course
            }
        }

        $positions = Position::where(
                'company_id', 0
            )
            ->orWhere(
                'company_id', session('company_id')
            )
            ->get();

        $position = [];

        foreach ($positions as $p) { // make a new array for correct position order
            $position[$p['id']] = $p['name'];
        }

        return view('course.show', compact('course', 'position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Course  $course
     * @return Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Course  $course
     * @return Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Course  $course
     * @return Response
     */
    public function destroy(Course $course)
    {
        //
    }

    /**
     * @return array
     */
    private function vaildateCourse(): array
    {
        return request()->validate([
            'name' => 'required|min:3|unique:companies,name,'.session('company_id').',id',
            'name_suffix' => 'nullable|min:3',
            'street' => 'required|min:3',
            'zipcode' => 'required',
            'location' => 'required|min:3',
        ]);
    }
}
