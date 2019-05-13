<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Cookie;


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
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        // $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            // 'captcha' => 'required|captcha',
            // 'password' => 'required|min:6|confirmed',
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // echo $data['recommender'];

        $recommender_id = User::where('recommender_code',$data['recommender'])->value('id');
        echo $recommender_id;
        exit;


        
       
        // // 쿠키 생성 
        $name = "chainplus";
        $value = uniqid('chainplus_',true);
        $minutes = time()+60*60*24*365;;

        Cookie::queue($name, $value, $minutes);

        $password = bcrypt("chainplus!QAZ");

        // 추천 코드 생성
        $recommender_code = uniqid('doublebet_');
        


        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'wallet_code' => $value,
            'recommender_code' => $recommender_code,
            'password' => $password,
        ]);
    }


}
