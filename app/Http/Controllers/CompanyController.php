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
use App\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
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
        $company = Company::findOrFail(session('company_id'));

        return view('company.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless($request->name != session('company'), 403);

        if ($request->qseh_password) { // password entered
            $request->request->add(['qseh_password' => encrypt($request->qseh_password)]); // encrypt the password
        }

        $company = Company::create($this->validateCompany());

        $user = Auth::user();
        $user->companies()->attach($company, ['company_active' => 1, 'user_active' => 1]); // Assign the user to the company
        $user->attachPermissions(Permission::all(), $company); // and attach all permissions

        $user->last_company = $company->id;
        $user->save();

        session([
            'company_id' => $company->id,
            'company' => $request['name'],
            'company_since' => Carbon::now()->toDateTimeString(),
        ]);

        $request->session()->flash('status', __('Company created'));

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        abort_unless(Auth::user()->isAbleTo('company.edit', session('company_id')), 403);

        $company = Company::findOrFail(session('company_id'));

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Company $company)
    {
        abort_unless(Auth::user()->isAbleTo('company.edit', $company), 403);

        if ($request->qseh_password == 'password-saved') { // if the password is saved in the DB
            $request->request->add(['qseh_password' => $company->qseh_password]); // set it to the request
        } elseif ($request->qseh_password) { // new password entered
            $request->request->add(['qseh_password' => encrypt($request->qseh_password)]); // encrypt the password
        }

        $company->update($this->validateCompany());

        session([
            'company_id' => $company->id,
            'company' => $request['name'],
        ]);

        $request->session()->flash('status', __('company updated'));

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    /**
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function activate(Company $company)
    {
        // TODO make me working!
        return 'TODO make me working!';
    }

    /**
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Company $company)
    {
        // TODO make me working!
        return 'TODO make me working!';
    }

    /**
     * @return array
     */
    private function validateCompany(): array
    {
        return request()->validate([
            'name' => 'required|min:3|unique:companies,name,'.session('company_id').',id',
            'name_suffix' => 'nullable|min:3',
            'street' => 'required|min:3',
            'zipcode' => 'required',
            'location' => 'required|min:3',
            'email' => 'nullable|email',
            'terms' => 'nullable|active_url',
            'cpolicy' => 'nullable|active_url',
            'doctor' => 'nullable|min:3',
            'reference' => 'nullable|min:6|max:6|required_with:qseh_password|unique:companies,reference,'.session('company_id'),
            'qseh_password' => 'nullable',
        ]);
    }
}
