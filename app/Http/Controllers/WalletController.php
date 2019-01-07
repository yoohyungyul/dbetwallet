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

        $resultVal = (object) [
            'message' => "",
            'flag' => false
        ];  


        // 주소 생성 테스트
        
        // $params = array($currency->password);
        // $client = new jsonRPCClient($currency->ip, $currency->port);
    	// $result = $client->request('personal_newAccount', $params);
        
        // 보내기 테스트
        // 보내는 주소 , 패스워드, 받는 사람 주소 , 갯수
        
        try 
        {

            $to = "0xe01c3f87166D035EF915116FD27B48Ae7D3543D7";
            $amount = 3000;
            $from = "0x007bb2cb9e1e9b7a4afb55332ddbd78e7b1611ec";
            $contractaddress = "0x099606ECb05d7E94F88EFa700225880297dD55eF";
            $passwd = $currency->password;
            $hex_sendTransaction = '0xa9059cbb000000000000000000000000';
            $funcs = "0xa9059cbb";

            $client = new jsonRPCClient($currency->ip, $currency->port);

                            
            

            // $real_to = str_pad(str_replace('0x','',$to), 64, '0', STR_PAD_LEFT);
            // $real_amount = str_pad(dechex(($amount)*pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);
            
            // $result = $client->request('personal_unlockAccount', ["0x1b4906b8140114af27c306280981d5e251f5d072", "123456", '0x0a']);

            // $result = $client->request('eth_sendTransaction', [[
            //     'from' => $parent->password,
            //     'to' => $currency->password,
            //     'data' => $funcs.$real_to.$real_amount,
            // ]]);




            

            // $real_to = str_replace('0x','',$to);
            // $real_amount = str_pad(dechex($amount * pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);

            $result1 = $client->request('personal_unlockAccount', ["0x1b4906b8140114af27c306280981d5e251f5d072", "123456", '0x0a']);

            

            // if (isset($result1->error))
            // {
            //     $resultVal->message = $result1->error->message;
            //     $resultVal->flag = false;  
            //     return $resultVal;          
            // }

            // $result = $client->request('eth_sendTransaction', [[
            //     'from' => $from,
            //     'to' => $contractaddress,
            //     'data' => $hex_sendTransaction . $real_to . $real_amount,
            // ]]);

            // if (isset($result->result)) 
            // {
            //     $resultVal->message = $result->result;
            //     $resultVal->flag = true;
            // } 
            // else if (isset($result->error)) 
            // {
            //     $resultVal->message = $result->error->message;
            // }
        } 
        catch(\Exception $e) 
            {
                $resultVal->message = "RPC Server Error";
                $resultVal->flag = false;
                
            }
        
        //return $resultVal;

        
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


curl --data '{"method":"personal_unlockAccount","params":["0x84f508c8726ec7dd1bb57f4de0c2fa70203fe283",")CFs=6~8mMzCxuPHkE+<j5rYV5/:E7NE",null],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101
curl --data '{"method":"personal_unlockAccount","params":["0x928531c958dd5524c94231253a21e5bc413efd1a","MelBITOrc@Msr-WalAddr#00000#$%",null],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101
curl --data '{"jsonrpc":"2.0","id":0,"method":"personal_unlockAccount","params":["0x099606ECb05d7E94F88EFa700225880297dD55eF","123456","0x0a"]}' -H "Content-Type: application/json" -X POST localhost:9101
*/