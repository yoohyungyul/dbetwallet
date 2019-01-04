<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\jsonRPCClient;

class WalletController extends Controller
{
   


    // 지갑 
    public function getWallet() {

        $client = new jsonRPCClient("172.31.20.32", "9101");
    	$result = $client->request('personal_newAccount', "123456");
    		
        print_R($result);
        exit;

        // print_R($this->isCookie());
        

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
*/