<?php

namespace App\Http\Controllers;

use App\Course;
use App\Participant;
use App\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('event.index');
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'number' => 'required',
            'code' => 'required|min:6|max:6',
        ]);

        return redirect(
            route(
                'event.login',
                [
                    'number' => $request->number,
                    'code' => $request->code,
                ]
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login($number, $code)
    {
        $code = Hashids::decode($code);

        if (! $code) { // if no code
            return redirect(route('event.index'))->withErrors( // code is wrong
                [
                    'message' => __('code wrong'),
                ]
            )
                ->withInput();
        } else {
            $code = $code[0];
        }

        $course = Course::where([
            ['internal_number', $number],
            ['running', $code],
        ])
            ->first();

        if (! $course) { // course not found
            return back()->withErrors(
                [
                    'message' => __('course not found'),
                ]
            )
                ->withInput();
        }

        // logout and delete old data
        Auth::guard()->logout();
        session()->invalidate();
        session()->regenerateToken();

        // register new data
        session([
            'course_id' => $course->id,
            'internal_number' => $course->internal_number,
            'courseDay_id' => $code,
        ]);

        return redirect(route('event.name'));
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

    public function name()
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        return view('event.name');
    }

    public function processName(Request $request)
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        $this->validate($request, [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'date_of_birth' => 'required|date',
        ]);

        // check for participant data
        $participant = Participant::where([
            ['course_id', session('course_id')],
            ['lastname', $request->last_name],
            ['firstname', $request->first_name],
        ])
            ->first();

        if ($participant) { // found data
            session([
                'lastname' => $participant->lastname,
                'firstname' => $participant->firstname,
                'date_of_birth' => $participant->date_of_birth,
                'company' => $participant->company,
                'street' => $participant->street,
                'zipcode' => $participant->zipcode,
                'location' => $participant->location,
                'email' => $participant->email,
                'payee' => $participant->payee,
            ]);
        } else {
            session([
                'lastname' => $request->last_name,
                'firstname' => $request->first_name,
                'date_of_birth' => Carbon::parse($request->date_of_birth)->format('Y-m-d'),
            ]);
        }

        return redirect(route('event.payee'));
    }

    public function selectPayee()
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        return view('event.select_payee');
    }

    public function showPayee(Request $request)
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        if ($request->payee_type == 'private') {
            session()->forget('company');
            session()->forget('zipcode');
            session()->forget('location');
            session()->forget('payee');

            return redirect(route('event.email'));
        }

        return view('event.show_payee_company');
    }

    public function company(Request $request)
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        $this->validate($request, [
            'company' => 'required|min:3',
            'zipcode' => 'nullable|min:3',
            'payee' => 'required',
        ]);

        session([
            'company' => $request->company,
            'zipcode' => $request->zipcode,
            'location' => $request->location,
            'payee' => $request->payee,
        ]);

        return redirect(route('event.email'));
    }

    public function email()
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        return view('event.email');
    }

    public function check()
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        if (session('company')) {
            return view('event.check_company');
        } else {
            return view('event.check_private');
        }
    }

    public function validating(Request $request)
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        $this->validate($request, [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'date_of_birth' => 'required|date',
            'approval' => 'accepted',
        ]);

        session([
            'lastname' => $request->last_name,
            'firstname' => $request->first_name,
            'date_of_birth' => Carbon::parse($request->date_of_birth)->format('Y-m-d'),
        ]);

        if ($request->company) { // check company data
            $this->validate($request, [
                'company' => 'required|min:3',
                'zipcode' => 'nullable|min:3',
                'payee' => 'required',
            ]);

            session([
                'company' => $request->company,
                'zipcode' => $request->zipcode,
                'location' => $request->location,
                'payee' => $request->payee,
            ]);
        }

        return redirect(route('event.sign'));
    }

    public function signature()
    {
        if (! session()->has('course_id') || ! session()->has('courseDay_id')) {
            return redirect(route('event.index'));
        }

        return view('event.signature');
    }

    public function finish(Request $request)
    {
        if (strlen($request->img) < 25) { // wasn't signed
            return back()
                ->withErrors(
                    ['message' => __('signature is required')]
                );
        }

        $participant = Participant::updateOrCreate(
            [
                'course_id' => session('course_id'),
                'lastname' => session('lastname'),
                'firstname' => session('firstname'),
                'date_of_birth' => session('date_of_birth'),
            ],
            [
                'company' => session('company'),
                'zipcode' => session('zipcode'),
                'location' => session('location'),
                'payee' => session('payee'),
                'participated' => 1,
            ]
        );

        // Let's save the sign as csv
        $sign = explode(',', $request->sign, 2);

        Signature::updateOrCreate(
            [
                'course_id' => session('course_id'),
                'participant_id' => $participant->id,
                'courseDay_id' => session('courseDay_id'),
            ],
            [
                'sign' => $sign[1],
            ]
        );

        $number = session('internal_number');
        $code = Hashids::encode(session('courseDay_id'));

        session()->invalidate();
        session()->regenerateToken();

        return view('event.finish', compact('number', 'code'));
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
