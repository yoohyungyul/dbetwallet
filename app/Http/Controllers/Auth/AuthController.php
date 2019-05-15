<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Cookie;
use Session;

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
            'captcha' => 'required|captcha',
            // 'password' => 'required|min:6|confirmed',
        ]);
    }


    public function postRegister(Request $request)
    {
        return $this->register($request);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $validator = $this->validator($request->all());

        exit;


        if($request->recommender) {
            $recommender_id = User::where('recommender_code',$request->recommender)->value('id');
            if(!$recommender_id) {
                Session::flash('sweet_alert', "회원을 찾을수 없습니다.");
                return Redirect::back();
            }
        }


        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        return redirect($this->redirectPath());
    }

    



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
       
        // // 쿠키 생성 
        $name = "chainplus";
        $value = uniqid('chainplus_',true);
        $minutes = time()+60*60*24*365;;

        Cookie::queue($name, $value, $minutes);

        $password = bcrypt("chainplus!QAZ");

        // 추천 코드 생성
        $recommender_code = uniqid('doublebet_');

        $recommender_id = 0;
        if($data['recommender']) {
            $recommender_id = User::where('recommender_code',$data['recommender'])->value('id');
        }

        


        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'wallet_code' => $value,
            'recommender_code' => $recommender_code,
            'recommender' => $recommender_id,
            'password' => $password,
        ]);
    }


}
