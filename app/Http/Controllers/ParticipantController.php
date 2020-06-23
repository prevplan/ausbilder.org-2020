<?php

namespace App\Http\Controllers;

use App\Course;
use App\Participant;
use App\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
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
     * @param  Course  $course
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Course $course)
    {
        abort_unless(Auth::user()->isAbleTo('participant.add', session('company_id'))
            && $course->company_id == session('company_id'), 403);
        if (Carbon::now() > $course->end) {
            return back()->withErrors([
                'message' => __('The course has already ended.'),
            ]);
        } elseif (count($course->participants) >= $course->seats) {
            return back()->withErrors([
                'message' => __('The course is already full.'),
            ]);
        }

        return view('participant.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Course $course)
    {
        abort_unless(Auth::user()->isAbleTo('participant.add', session('company_id'))
            && $course->company_id == session('company_id'), 403);

        if (Carbon::now() > $course->end) {
            return back()->withErrors([
                'message' => __('The course has already ended.'),
            ]);
        } elseif (count($course->participants) >= $course->seats) {
            return back()->withErrors([
                'message' => __('The course is already full.'),
            ]);
        }

        $price = Price::findOrFail($request->price);

        $price = $price->price;

        Participant::create([
            'course_id' => $course->id,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'date_of_birth' => $request->date_of_birth,
            'street' => $request->street,
            'zipcode' => $request->zipcode,
            'location' => $request->location,
            'email' => $request->mail,
            'price' => $price,
            'price_id' => $request->price,
        ]);

        session()->flash('status', __('participant added'));

        return redirect()->route('course.show', ['course' => $course]);
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
