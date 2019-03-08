<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Auth\Guard;
use Auth;
use Cookie;
use App\User;
Use Request;

class MyCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }



    public function handle($request, Closure $next)
    {

        // Cookie::queue(Cookie::forget('chaninplus'));


        // $cookie = Cookie::forget('chaninplus');

        // echo Cookie::get('chainplus');
        // exit;


        // 쿠키 체크 있으면
        if(Cookie::get('chainplus')) {


            if(!Request::is("2fa/*") ){
                // 쿠키로 회원 정보 가져오기
                $userDB = User::where('wallet_code',cookie::get('chainplus'))->first();

                // 회원 정보가 있을 경우 
                if($userDB) {
                    // 세션 생성
                    if(!Auth::check()) Auth::login($userDB);

                    // otp 설정이 되여 있는지 확인
                    if(!Auth::user()->google2fa_secret) {
                        return redirect("/2fa/enable");
                    }
                
                // 없을 경우
                } else {
                    // 쿠키 초기화 하고 회원등록 화면으로 이동
                    Cookie::forget('chainplus');
                    return redirect("/register");
                }
            }




        // 없으면 회원가입창으로 
        } else {
            return redirect("/register");

        }
        


        return $next($request);  
    }
}
