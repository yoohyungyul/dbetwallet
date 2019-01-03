<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Cookie;
use DB;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    public function isCookie() {

        // 기존 접속 기록이 있으면
        if(Cookie::get('chaninplus')) {
            $UserData = $user = User::where('wallet_code', '=', Cookie::get('chaninplus'))->first();
        
            return $UserData;
        // 없으면 
        } else {
            return "";
        }
        
        
    }
}
