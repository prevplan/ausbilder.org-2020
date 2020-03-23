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
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Company  $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Company $company, $code)
    {
        $invitation = $this->check($company, $code);

        if (! $invitation) { // invitation code not found
            return view('invitation.not-found');
        } else {
            return view('invitation.index', compact(['company', 'code']));
        }
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
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Accept the invitation as logged in user.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Company $company, $code)
    {
        $invitation = $this->check($company, $code);

        abort_unless($invitation, 403); // invitation code not found

        Auth::user()->companies()->syncWithoutDetaching(
            [
                $company->id => ['company_active' => 1, 'user_active' => 1],
            ]
        );

        $invitation->delete(); // delete the invitation

        return redirect()->route('company-change-id', ['company' => $company->hashid()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Company $company, $code)
    {
        $invitation = $this->check($company, $code);

        abort_unless($invitation, 403); // invitation code not found

        $invitation->delete(); // delete the invitation

        return redirect('/');
    }

    /**
     * @param  Company  $company
     * @param $code
     * @return mixed
     */
    private function check(Company $company, $code)
    {
        $invitation = Invitation::where([
            ['company_id', $company->id],
            ['code', $code],
        ])->first();

        return $invitation;
    }
}
