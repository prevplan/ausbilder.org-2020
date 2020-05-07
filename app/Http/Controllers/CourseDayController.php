<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class CourseDayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Start the course day.
     *
     * @param  Course  $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function start(Course $course)
    {
        $user_in = false;
        foreach ($course->user as $user) {
            if ($user->id == Auth::user()->id) {
                $user_in = true;
            }
        }

        abort_unless(
            Auth::user()->isAbleTo('course.perform-electronically', session('company_id'))
            && $course->company_id == session('company_id')
            && $user_in, 403
        );

        if ($course->running) {
            return back()->withErrors(
                [
                    'message' => __('course day is already started'),
                ]
            );
        } elseif (Carbon::now() > $course->end) {
            return back()->withErrors(
                [
                    'message' => __('course has already finished'),
                ]
            );
        }

        $time = $this->roundToQuarterHour('up');

        return view('courseday.start', compact('course', 'time'));
    }

    /**
     * Store the course day start.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store_start(Request $request)
    {
        $course = Course::findByHashidOrFail($request->course_id);

        $user_in = false;
        foreach ($course->user as $user) {
            if ($user->id == Auth::user()->id) {
                $user_in = true;
            }
        }

        abort_unless(
            Auth::user()->isAbleTo('course.perform-electronically', session('company_id'))
            && $course->company_id == session('company_id')
            && $user_in
            && $course->running == 0
            && Carbon::now() < $course->end, 403
        );

        $this->validate($request, [
            'start_date' => 'required|date|date_equals:'.Carbon::now()->StartOfDay(),
            'start_time' => 'required|date_format:"H:i"',
        ]);

        $start = $request->start_date.' '.$request->start_time.':00';

        $courseDay = CourseDay::create([
            'course_id' => Hashids::decode($request->course_id)[0],
            'start_id' => Auth::user()->id,
            'startDay' => $start,
            'startReal' => Carbon::now(),
        ]);

        $course->running = $courseDay->id;
        //    $course->code = random_int(1000,9999);
        $course->save();

        return redirect(route('course.show', $request->course_id));
    }

    /**
     * end the course day.
     *
     * @param  Course  $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function end(Course $course)
    {
        $user_in = false;
        foreach ($course->user as $user) {
            if ($user->id == Auth::user()->id) {
                $user_in = true;
            }
        }

        abort_unless(
            Auth::user()->isAbleTo('course.perform-electronically', session('company_id'))
            && $course->company_id == session('company_id')
            && $user_in, 403
        );

        if (! $course->running) {
            return back()->withErrors(
                [
                    'message' => __('course day is not running'),
                ]
            );
        }

        $courseDay = CourseDay::findOrFail($course->running);

        $time = $this->roundToQuarterHour('down');

        $start = Carbon::parse($courseDay->startDay);

        $duration = $start->diffInMinutes($time);

        // calc the lessons without the breaks
        if ($duration > 90 && $duration <= 190) {
            $duration = $duration - 15;
        } elseif ($duration > 190 && $duration <= 300) {
            $duration = $duration - 30;
        } elseif ($duration > 300) {
            $duration = $duration - 45;
        }

        $lessons = floor($duration / 45);

        // but max. 10 lessons / day
        if ($lessons > 10) {
            $lessons = 10;
        }

        return view('courseday.end  ', compact('course', 'time', 'lessons'));
    }

    /**
     * Store the course day end.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store_end(Request $request)
    {
        $course = Course::findByHashidOrFail($request->course_id);

        $user_in = false;
        foreach ($course->user as $user) {
            if ($user->id == Auth::user()->id) {
                $user_in = true;
            }
        }

        abort_unless(
            Auth::user()->isAbleTo('course.perform-electronically', session('company_id'))
            && $course->company_id == session('company_id')
            && $user_in
            && $course->running, 403
        );

        $this->validate($request, [
            'end_date' => 'required|date|date_equals:'.Carbon::now()->StartOfDay(),
            'end_time' => 'required|date_format:"H:i"',
        ]);

        $end = $request->end_date.' '.$request->end_time.':00';

        CourseDay::findOrFail($course->running)
            ->update([
                'end_id' => Auth::user()->id,
                'endDay' => $end,
                'endReal' => Carbon::now(),
                'lessonsDay' => $request->lessons,
            ]);

        $course->running = 0;
        $course->save();

        return redirect(route('course.show', $request->course_id));
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

    public function roundToQuarterHour($round = '')
    {
        if ($round == 'down') {
            $t = floor(strtotime(Carbon::now()) / 900) * 900;
        } elseif ($round == 'up') {
            $t = ceil(strtotime(Carbon::now()) / 900) * 900;
        } else {
            $t = round(strtotime(Carbon::now()) / 900) * 900;
        }

        return date('Y-m-d H:i:s', $t);
    }
}
