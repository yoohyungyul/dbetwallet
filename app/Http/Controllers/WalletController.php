<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\jsonRPCClient;
use App\Currency;
use App\Balance;
use App\Users_wallet;
use App\TransactionHistory;
use Validator;
use Cache;
use Google2FA;
use Carbon\Carbon;


class WalletController extends Controller
{
   
    
    // 지갑 
    public function getWallet() {


        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();


        $client = new jsonRPCClient($currencyData->ip, $currencyData->port);

        $result = $client->request('eth_getBalance', ["0xd00caff16b310ef3ba4b23911d83763ad766584a", 'latest']);
        echo "이더 : ".hexdec($result->result)/pow(10,18)."<br>";
        
        // 토큰 조회
        $result = $client->request('eth_call', [[ 
            "to" => "0x099606ECb05d7E94F88EFa700225880297dD55eF", 
            "data" => "0x70a08231000000000000000000000000" . str_replace("0x","","0xd00caff16b310ef3ba4b23911d83763ad766584a") ]]);
        echo "토큰 : ".hexdec($result->result)/pow(10,8);

        exit;



        

        
        $walletData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();
        $balanceData = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();

        
        return view('wallet.wallet',[
            'currency' => $currencyData,
            'wallet' => $walletData,
            'balance' => $balanceData

        ]);
    }

    // 거래 내역
    public function getHistory() {

        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $balanceData = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();


        $transactions = TransactionHistory::where('currency_id', '=', env('CURRENCY_ID', '1'))
            ->where('user_id',Auth::user()->id)
            ->orderBy('state')->orderBy('created_at','desc')->paginate(10);

        

        
        return view('wallet.history', [
            'currency' => $currencyData,
            'balance' => $balanceData,
            'list' => $transactions,
        ]);

        
        
    }

    // 보내기
    public function getSend() { 

        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $balanceData = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();


        return view('wallet.send',[
            'currency' => $currencyData,
            'balance' => $balanceData

        ]);
    }

    // 보내기 처리
    public function postSend(Request $request) {

        $balance = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();
        $walletData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();
        

        if ($balance->balance < $request->amount) {
            return back()->withErrors('Balance is not enough!');
        }

        if(Auth::user()->withdraw_flag){
			return back()->withErrors('You are subject to withdrawal restrictions.');
		}


        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'address' => 'required',
            'totp' => 'required|digits:6',
        ]);
        

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $isAddress = Users_wallet::where('address',$request->address)->count();
        if(!$isAddress) return back()->withErrors('Invalid address.');

     
        $key = Auth::user()->id . ':' . $request->totp;

        if(Cache::has($key)) {
           return back()->withErrors('This is the OTP code already used.');
        }

        if(!Google2FA::verifyKey(Auth::user()->google2fa_secret, $request->totp)) {
          
            return back()->withErrors('OTP code mismatch.');
        }

        
      
        

        try {
            DB::beginTransaction();

            // 거래 내역 등록
            $transaction_history = new TransactionHistory;
            $transaction_history->user_id = Auth::user()->id;
            $transaction_history->currency_id = env('CURRENCY_ID', '1');
            $transaction_history->type = 1;
            $transaction_history->amount = $request->amount;
            $transaction_history->address_from = $walletData->address;
            $transaction_history->address_to = $request->address;
            $transaction_history->balance = $balance->balance - $request->amount;
            $transaction_history->push();
         

            $balance->balance -= $request->amount;
            $balance->push();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors('Oops, database error is occurred!');

           
        } finally {
            DB::commit();
        }

        return redirect('/history' )->with('message', 'send has been completed');
    

    }
}

/*
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