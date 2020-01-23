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
use App\Invitation;
use App\Mail\TrainerInvite;
use App\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TrainerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Company::find(session('company_id'))->users;

        return view('trainer.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Auth::user()->can('trainer.add', session('company_id')), 403);

        return view('trainer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(Auth::user()->can('trainer.add', session('company_id')), 403);

        request()->validate([
            'email' => 'required|email',
        ]);

        $company = Company::findOrFail(session('company_id'));

        // check if is already a trainer
        if (in_array($request->email, $company->users()->pluck('email')->toArray())) {
            return redirect()->route('trainer.show')->with('error', __('already a trainer'));
        }

        $invited = Invitation::where([
            ['company_id', $company->id],
            ['email', $request->email],
        ])->first();

        if ($invited) { // already invited
            return redirect()->route('trainer.show')->with('error', __('already invited'));
        }

        // no actual trainer and not invited, at the moment

        $code = Str::random(20);

        $invitation = Invitation::create(
            [
                'company_id' => session('company_id'),
                'email' => $request->email,
                'invited_by' => auth()->user()->id,
                'code' => $code,
            ]
        );

        Mail::to($request->email)
            ->send(new TrainerInvite($company, $code));

        return redirect()->route('trainer.show')->with('message', __('trainer invited'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        //
    }
}
