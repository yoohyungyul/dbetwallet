<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\jsonRPCClient;
use App\Currency;
use App\TransactionHistory;
use Cookie;

class WalletController extends Controller
{
   


    // 지갑 
    public function getWallet() {


        Cookie::forget('chaninplus');


        echo Cookie::get('chaninplus');
        return view('wallet.wallet');

        $currency = Currency::where('state', '=', 1)->where('id', '=', "1")->first();

        $resultVal = (object) [
            'message' => "",
            'flag' => false
        ];  

        try 
        {

            $to                     = "0x1d4aa94a86c600dddaac24e57f71622f4e7f229d";
            $amount                 = 10;
            $from                   = "0x1b4906b8140114af27c306280981d5e251f5d072";
            $contractaddress        = "0x099606ECb05d7E94F88EFa700225880297dD55eF";
            $passwd                 = $currency->password;
            $hex_sendTransaction    = '0xa9059cbb000000000000000000000000';
            $hex_getbalance         = '0x70a08231000000000000000000000000';
            $funcs                  = "0xa9059cbb";

            $client = new jsonRPCClient($currency->ip, $currency->port);



             // 주소 생성 테스트 - 완료
        
            // $params = array($currency->password);
            // $client = new jsonRPCClient($currency->ip, $currency->port);
            // $result = $client->request('personal_newAccount', $params);
        



    

            // 잔액 조회 - 완료 

            // 이더 조회
            // $result = $client->request('eth_getBalance', ["0x007bB2cb9e1e9B7a4aFB55332DDbD78E7b1611EC", 'latest']);
            // echo hexdec($result->result)/pow(10,8);
            

            // 토큰 조회
            // $result = $client->request('eth_call', [[ 
            //  "to" => $contractaddress, 
            //  "data" => $hex_getbalance . str_replace("0x","","0x1B4906B8140114aF27c306280981d5e251f5D072") ]]);
            // echo hexdec($result->result)/pow(10,8);
               



                            
            // 보내기 - 진행중
            // 보내는 주소는 서버에서 만든 주소만 가능??(테스트 해본 결과 서버에서 만든 주소만 가능)
            // $real_to = str_pad(str_replace('0x','',$to), 64, '0', STR_PAD_LEFT);
            // $real_amount = str_pad(dechex(($amount)*pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);
            
            // $result = $client->request('personal_unlockAccount', [$from, "123456", '0x0a']);

            // if (isset($result->error))
            // {
            //     $resultVal->message = $result1->error->message;
            //     $resultVal->flag = false;  
            //     return $resultVal;          
            // }
            
            // $real_to = str_pad(str_replace('0x','',$to), 64, '0', STR_PAD_LEFT); 
            // $real_amount = str_pad(dechex( $amount * pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);
            
            // $result = $client->request('eth_sendTransaction', [[
            //     'from' => $from,
            //     'to' => $contractaddress,
            //     'data' =>  $funcs.$real_to.$real_amount,
            // ]]);

            // print_R($result);
            // exit;

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
            // $resultVal->message = "RPC Server Error";
            // $resultVal->flag = false;
            
        }
        
        //return $resultVal;

        
    }

    // 거래 내역
    public function getHistory() {

        // 쿠키 체크
        $UserData = $this->isCookie();

        // 회원 정보가 있을 경우
        if($UserData) {

            $page = Input::get('page');
            if(!$page) $page = 1;


            $total = TransactionHistory::where('currency_id', '=', env('CURRENCY_ID', '1'))->get()->count();
            if ($page > floor($total / 20)) 
            {
                $page = floor($total / 20);
            }

            $transactions = TransactionHistory::where('currency_id', '=', env('CURRENCY_ID', '1'))->orderBy('state')->orderBy('created_at','desc')->skip($page * 20)->take(20)->get();



            $transactions_dict = [];        
            $i = $page * 20;    
            foreach ($transactions as $transaction) 
            {
                $i++;
               
                $transactions_dict[] = (object) [
                    'index' => $i,
                    'data' => $transaction
                ];
            }

            $paging = (object) [
                'start' => 0,
                'end' => floor($total / 20),
                'paging_start' => floor($page / 10)*10,
                'paging_end' => floor($page / 10)*10 + 9,
                'prev' => $page - 10,
                'next' => $page + 10,
                'page' => $page
            ];

            if ($paging->paging_end > $paging->end) 
            {
                $paging->paging_end = $paging->end;
            }

            if ($paging->prev < 0) 
            {
                $paging->prev = 0;
            }

            if ($paging->next > $paging->end) 
            {
                $paging->next = $paging->end;
            }
            
            return view('wallet.history', [
                'list' => $transactions_dict,
                'paging' => $paging,
            ]);

        // 없을 경우 로그인 창으로 
        } else {

        }
        
    }

    // 보내기
    public function getSend() { 

        return view('wallet.send');
    }
}


/*
curl --data '{"method":"eth_accounts","params":[],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101


curl --data '{"method":"personal_newAccount","params":["123456"],"id":2,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101
curl --data '{"method":"personal_newAccount","params":["MelonBIT@Master-Wallet#000001"],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101

curl --data  '{"method":"personal_newAccount","params":["123456"],"id":0,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101


curl --data  '{"jsonrpc":"2.0","id":0,"method":"personal_newAccount","params":"123456"}' -H "Content-Type: application/json" -X POST 54.180.124.202:9101


curl --data '{"method":"personal_unlockAccount","params":["0x84f508c8726ec7dd1bb57f4de0c2fa70203fe283",")CFs=6~8mMzCxuPHkE+<j5rYV5/:E7NE",null],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101
curl --data '{"method":"personal_unlockAccount","params":["0x928531c958dd5524c94231253a21e5bc413efd1a","MelBITOrc@Msr-WalAddr#00000#$%",null],"id":1,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101
curl --data '{"jsonrpc":"2.0","id":0,"method":"personal_unlockAccount","params":["0x099606ECb05d7E94F88EFa700225880297dD55eF","123456","0x0a"]}' -H "Content-Type: application/json" -X POST localhost:9101


[{"from":"0x84f508c8726ec7dd1bb57f4de0c2fa70203fe283","to":"0x6c86228d240c22d4f4744654026326895351b2ec","data":"0xa9059cbb00000000000000000000000056274a0bef07821a4f3e111438dfbdc7feb898b10000000000000000000000000000000000000000000000000000000000000316"}],"id":7,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101

[{"from":"0x1b4906b8140114af27c306280981d5e251f5d072","to":"0x099606ecb05d7e94f88efa700225880297dd55ef","data":"0xa9059cbb0000000000000000000000001d4aa94a86c600dddaac24e57f71622f4e7f229d00000000000000000000000000000000000000000000000000000002540be400"}]}
*/