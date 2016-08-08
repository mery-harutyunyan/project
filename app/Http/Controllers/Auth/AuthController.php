<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Mailer\MyMailer;

use Illuminate\Http\Request;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'getLogout']]);
    }

    public function postRegister(Request $request, MyMailer $mailer)
    {
        // validate new user
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|between:3,8|confirmed',
            'password_confirmation' => 'required|string|between:3,8',
        ]);

        if ($validator->fails()) {
            return redirect('auth/register')
                ->withErrors($validator)
                ->withInput();
        }

        // add new user to DB
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_token' => str_random(30)
        ]);

        //send user verification email
        if ($user) {
            $mailer->emailVerification($user);
        }

    }


    public function verify($token)
    {
        $user = User::whereEmailToken($token)->firstOrFail();

        $user->active = 1;
        $user->email_token = null;

        $user->save();

        return redirect('auth/login');

    }

    public function postLogin(Request $request)
    {
        // validate login credentionals
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|between:3,8',
        ]);

        if ($validator->fails()) {
            return redirect('auth/login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt($this->getCredentials($request))) {
            return redirect('dashboard');
        }

        return redirect('auth/login')
            ->withErrors([
                'user_error' => 'User does not exists or not activated'
            ])
            ->withInput();

    }

    protected function getCredentials($request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1
        ];
    }


    public function getLogout()
    {
        Auth::logout();
        return redirect('auth/login');
    }
}
