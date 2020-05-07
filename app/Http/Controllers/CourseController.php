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
use Vyuldashev\XmlToArray\XmlToArray;

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
        if (Auth::user()->isAbleTo('course.view', session('company_id'))) {
            $courses = Course::where([
                ['company_id', session('company_id')],
                ['end', '>', Carbon::today()],
            ])
                ->with('course_types')
                ->with('user')
                ->orderBy('start', 'desc')
                ->get();
        } else { // show only own courses
            $course = DB::table('course_user')
                ->where('user_id', Auth::user()->id)
                ->get();

            $courses = Course::whereIn('id', $course->pluck('course_id'))
                ->where('company_id', session('company_id'))
                ->where('end', '>', Carbon::today())
                ->with('course_types')
                ->orderBy('start', 'desc')
                ->get();
        }

        return view('course.index', compact('courses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function old()
    {
        if (Auth::user()->isAbleTo('course.view', session('company_id'))) {
            $courses = Course::where([
                ['company_id', '=', session('company_id')],
                ['end', '<', Carbon::today()],
            ])
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
                ->where('end', '<', Carbon::today())
                ->with('course_types')
                ->orderBy('start', 'asc')
                ->get();
        }

        return view('course.old', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        abort_unless(Auth::user()->isAbleTo('course.add', session('company_id')), 403);

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
        abort_unless(Auth::user()->isAbleTo('course.add', session('company_id')), 403);

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
            'internal_number' => 'required_without_all:registration_number,auto_register|nullable|min:3|alpha_dash',
            'registration_number' => 'required_without_all:internal_number,auto_register|nullable|min:6',
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

        if ($request->auto_register) { // want to register the course at the QSEH
            abort_unless(Auth::user()->isAbleTo('course.register', session('company_id')), 403);

            $company = Company::where([
                ['id', session('company_id')],
            ])
                ->first();

            if ($company->reference && $company->qseh_password) {
                $password = decrypt($company->qseh_password);
            } else { // no data saved
                abort(403);
            }

            $type = CourseType::where([
                ['id', $request->type],
            ])
                ->first();

            if (! $type->wsdl_id) { // no wsdl_id -> no QSEH Course
                return back()
                    ->withErrors(['message' => __('selected Course type is no QSEH Course')])
                    ->withInput($request->all);
            }

            if ($request->start_date == $request->end_date) { // only 1 day
                $time = $request->start_time.' Uhr - '.$request->end_time.' Uhr';
            } else { // more than 1 day
                $time = Carbon::parse($request->start_date)->format('d.m.y')
                    .' - '.
                    Carbon::parse($request->end_date)->format('d.m.y')
                    .' / '.
                    $request->start_time
                    .' Uhr - '.
                    $request->end_time.' Uhr';
            }

            $response = $this->qseh_webservice( // register course at QSEH
                $company->reference,
                $password,
                'Neu',
                $type->wsdl_id,
                $start,
                $time,
                $request->seminar_location,
                $request->location,
                $request->zipcode,
                $request->street
            );

            if ($response['ns1:code'] == '1') { //successful
                $registration_number = $response['ns1:beschreibung'];
                $registered = true;
            } elseif ($response['ns1:code'] == '401') { // wrong password
                $company->qseh_password = null; // delete password
                $company->save();

                return back()
                    ->withErrors(['message' => __('No valid QSEH access data.')])
                    ->withInput($request->all);
            } else {
                return back()
                    ->withErrors(['message' => __('Error - QSEH reports:').' '.$response['ns1:beschreibung']])
                    ->withInput($request->all);
            }
        } else { // don't register course automatically
            $registration_number = $request->registration_number;
            $registered = false;
        }

        if (! $request->internal_number) {
            $request->internal_number = $registration_number;
        }

        $course = Course::create([
            'company_id' => session('company_id'),
            'type' => $request->type,
            'internal_number' => $request->internal_number,
            'registration_number' => $registration_number,
            'registered' => $registered,
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
        $user_in = false;
        foreach ($course->user as $user) {
            if ($user->id == Auth::user()->id) {
                $user_in = true;
            }
        }

        abort_unless(
            Auth::user()->isAbleTo('course.view', session('company_id'))
                && $course->company_id == session('company_id')
            || $user_in
                && $course->company_id == session('company_id'), 403
        );

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

        return view('course.show', compact('course', 'position', 'user_in'));
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

    /**
     * @param $reference
     * @param $password
     * @param $action
     * @param $course_type
     * @param $start
     * @param $time
     * @param $seminar_location
     * @param $location
     * @param $zipcode
     * @param $street
     * @param  string  $notice
     * @param  string  $course_id
     * @return mixed
     */
    private function qseh_webservice($reference, $password, $action, $course_type, $start, $time, $seminar_location, $location, $zipcode, $street, $notice = '', $course_id = '')
    {
        $soap_request = '<?xml version="1.0" encoding="UTF-8"?>

        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
            xmlns:ehaf="http://www.portsol19.de/Ehaf3LehrgangService/"
            xmlns:xsd="http://www.vbg.de.uv_services.ehaf3.bibliothek/xsd">
            <soapenv:Header/>
            <soapenv:Body>
                <ehaf:ehaf3RequestHandler>
                    <LehrgangsUebermittlung>
                        <xsd:absenderID>system@ausbilder.org</xsd:absenderID>
                        <xsd:empfaengerID>ehaf</xsd:empfaengerID>
                        <xsd:sendungsID>1</xsd:sendungsID>
                        <xsd:serviceID>1</xsd:serviceID>
                        <xsd:zeitstempel>'.Carbon::now()->format('Y-m-d\TH:i:s').'</xsd:zeitstempel>
                        <lehrgang>
                            <xsd:lehrgangsArt>'.$course_type.'</xsd:lehrgangsArt>
                            <xsd:startDatum>'.Carbon::parse($start)->format('Y-m-d\TH:i:s').'</xsd:startDatum>
                            <xsd:zeitlicherVerlauf>'.$time.'</xsd:zeitlicherVerlauf>
                            <xsd:adresseFirma>'.str_replace('&', 'u.', $seminar_location).'</xsd:adresseFirma>
                            <xsd:adresseOrt>'.$location.'</xsd:adresseOrt>
                            <xsd:adressePlz>'.$zipcode.'</xsd:adressePlz>
                            <xsd:adresseStrasse>'.$street.'</xsd:adresseStrasse>
                            <!--Optional:-->
                            <xsd:vermerk>'.$notice.'</xsd:vermerk>
                            <!--Optional:-->
                            <xsd:lehrId>'.$course_id.'</xsd:lehrId>
                        </lehrgang>
                        <Benutzer>'.$reference.'</Benutzer>
                        <Kennwort>'.$password.'</Kennwort>
                        <Aktion>'.$action.'</Aktion>
                    </LehrgangsUebermittlung>
                </ehaf:ehaf3RequestHandler>
            </soapenv:Body>
        </soapenv:Envelope>';

        $headers = [
            'Content-type: text/xml',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: Ehaf3LehrgangService.wsdl',
            'Content-length: '.strlen($soap_request),
        ];

        $url = 'https://www.bg-qseh.de/login/perl/service.pl?LehrgangsService';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soap_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $output = curl_exec($ch);

        curl_close($ch);

        $return = XmlToArray::convert($output);

        return $return['soapenv:Envelope']['soapenv:Body']['ns2:ehaf3RequestHandlerResponse']['return'];
    }
}
