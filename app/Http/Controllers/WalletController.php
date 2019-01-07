<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\jsonRPCClient;
use App\Currency;

class WalletController extends Controller
{
   


    // 지갑 
    public function getWallet() {



        $currency = Currency::where('state', '=', 1)->where('id', '=', "1")->first();

        $params = array($currency->password);

        $client = new jsonRPCClient($currency->ip, $currency->port);
    	$result = $client->request('personal_newAccount', $params);
        
        print_R($result);
        

        // echo uniqid('chainplus_',true);

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


// chainplus_5c2c60134e86b9.78143218
// 33자리

/*
curl --data '{"method":"eth_accounts","params":[],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101


curl --data '{"method":"personal_newAccount","params":["123456"],"id":2,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101
curl --data '{"method":"personal_newAccount","params":["MelonBIT@Master-Wallet#000001"],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101

curl --data  '{"method":"personal_newAccount","params":["123456"],"id":0,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101


curl --data  '{"jsonrpc":"2.0","id":0,"method":"personal_newAccount","params":"123456"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101
*/