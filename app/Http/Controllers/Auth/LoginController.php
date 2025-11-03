<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Trez\RayganSms\Facades\RayganSms;

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

    public function logout(Request $request)
    {
        $data =  session()->get('cart');
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerate();
        session()->put('cart', $data);
        return $this->loggedOut($request) ?: redirect('/shop');
    }

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

    public function username()
    {
        $input = request()->all();
        $login = request()->input('login');
        $fieldType = filter_var(request()->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }
    
    protected function authenticated($request,$user){
        if($user->isAdmin()){
            return redirect()->route('dashboard'); //redirect to admin panel
        }

        return redirect()->intended(RouteServiceProvider::HOME); //redirect to standard user homepage
    }

}//end

