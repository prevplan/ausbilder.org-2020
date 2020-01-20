<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $company = Company::find($user->last_company);

        if (! $company) {
            return false;
        } // continue, if last company is false

        $active = $company->users()
            ->wherePivot('company_active', 1)
            ->wherePivot('user_active', 1)
            ->first();

        if ($active) { // is still active member of last company
            session([
                'company_id' => $company->id,
                'company' => $company->name,
            ]);
        } else { // no member anymore
            $user->last_company = false;
            $user->save();
        }
    }
}
