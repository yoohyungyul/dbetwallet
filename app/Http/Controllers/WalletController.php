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


        // 주소 생성 테스트
        $currency = Currency::where('state', '=', 1)->where('id', '=', "1")->first();
        // $params = array($currency->password);
        // $client = new jsonRPCClient($currency->ip, $currency->port);
    	// $result = $client->request('personal_newAccount', $params);
        
        // 보내기 테스트
        // 보내는 주소 , 패스워드, 받는 사람 주소 , 갯수
        // $this->orc_sendtransfer($sender, $pwd, $receiver, $amount);

        // $client = new jsonRPCClient($currency->ip, $currency->port);

        $to = "0xe01c3f87166D035EF915116FD27B48Ae7D3543D7";
        $amount = 3000;


        $real_to = str_replace('0x','',$to);
        $real_amount = str_pad(dechex($amount * pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);

        echo $real_to."<br>";
        echo $real_amount;
        exit;

        
        // $result1 = $client->request('personal_unlockAccount', [$from, $passwd, '0x0a']);
        // //print_r($result);
        // if (isset($result1->error))
        // {
        //     $resultVal->message = $result1->error->message;
        //     $resultVal->flag = false;  
        //     return $resultVal;          
        // }

        // $result = $client->request('eth_sendTransaction', [[
        //     'from' => $from,
        //     'to' => $this->orc_contractaddress,
        //     'data' => $this->hex_sendTransaction . $real_to . $real_amount,
        // ]]);

        // //print_r($result);
        // if (isset($result->result)) 
        // {
        //     $resultVal->message = $result->result;
        //     $resultVal->flag = true;
        // } 
        // else if (isset($result->error)) 
        // {
        //     $resultVal->message = $result->error->message;
        //     $resultVal->flag = false;
        // }



        // function orc_sendtransfer($from, $passwd, $to, $amount)
        // {
        //     $resultVal = (object) [
        //         'message' => "",
        //         'flag' => false
        //     ];  

        //     try 
        //     {
        //         $client = new jsonORCRPCClient($this->rpcserver_ip, $this->rpcserver_port);
                
        //         //$real_to = str_pad(str_replace('0x','',$to), 64, '0', STR_PAD_LEFT);
        //         $real_to = str_replace('0x','',$to);
        //         $real_amount = str_pad($this->dec2hex($amount * pow(10,$this->orc_digit)), 64, '0', STR_PAD_LEFT);
                
        //         $result1 = $client->request('personal_unlockAccount', [$from, $passwd, '0x0a']);
        //         //print_r($result);
        //         if (isset($result1->error))
        //         {
        //             $resultVal->message = $result1->error->message;
        //             $resultVal->flag = false;  
        //             return $resultVal;          
        //         }

        //         $result = $client->request('eth_sendTransaction', [[
        //             'from' => $from,
        //             'to' => $this->orc_contractaddress,
        //             'data' => $this->hex_sendTransaction . $real_to . $real_amount,
        //         ]]);

        //         //print_r($result);
        //         if (isset($result->result)) 
        //         {
        //             $resultVal->message = $result->result;
        //             $resultVal->flag = true;
        //         } 
        //         else if (isset($result->error)) 
        //         {
        //             $resultVal->message = $result->error->message;
        //             $resultVal->flag = false;
        //         }

        //     } 
        //     catch(\Exception $e) 
        //     {
        //         $resultVal->message = "RPC Server Error";
        //         $resultVal->flag = false;
        //     }

        //     return $resultVal;
        // }
        
        

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