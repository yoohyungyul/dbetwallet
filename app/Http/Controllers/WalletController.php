<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cookie;

class WalletController extends Controller
{
   


    // 지갑 
    public function getWallet() {


        

        echo uniqid('chainplus_',true);

        // $name = "chaninplus";
        // $value = "0923";
        // $minutes = 216000;

        // Cookie::queue($name, $value, $minutes);

        
        return view('wallet.wallet');
    }

    // 거래 내역
    public function getHistory() {

        // echo Cookie::get('chaninplus');

        return view('wallet.history');
    }

    // 보내기
    public function getSend() {

        return view('wallet.send');
    }
}
