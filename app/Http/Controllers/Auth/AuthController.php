<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Mailer\MyMailer;
use Illuminate\Support\Facades\Session;

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
        $this->middleware($this->guestMiddleware(), ['except' => ['getLogout']]);
    }

    /**
     * @param Request $request
     * @param MyMailer $mailer
     * @return $this
     */
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
            //get user role id
            $userRoleId = Role::where('name', 'user')
                ->select('id')
                ->first()
                ->id;


            // add user's role

            $addRole = RoleUser::create([
                'user_id' => $user->id,
                'role_id' => $userRoleId
            ]);

            $mailer->emailVerification($user);

            Session::flash('note.success', 'You have successfuly registered.Please check your email to verify your account');

            return redirect('/');
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

            $user = User::find(Auth::user()->id);

            if($user->hasRole('admin')){
                return redirect('/products');
            }

            if($user->hasRole('user')){
                return redirect('/');
            }

        }


        Session::flash('note.error', 'User does not exists or not activated');

        return redirect('auth/login')->withInput();

    }

    protected function getCredentials($request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1,
        ];
    }


    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
