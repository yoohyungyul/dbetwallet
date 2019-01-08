<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Auth\Guard;
use Auth;

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
        

        if(Auth::check()){
            echo "1";
        } else {
            echo "2";
            
        }

        // $UserData = [];

        // 기존 접속 기록이 있으면
        // if(Cookie::get('chaninplus')) {
        //     $UserData = User::where('wallet_code',  Cookie::get('chaninplus'))->first();
        // }

        // return $UserData;






        return $next($request);  
    }
}
