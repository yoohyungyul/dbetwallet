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
use App\User;
use App\Users_wallet;
use App\TransactionHistory;
use Validator;
use Cache;
use Session;
use Cookie;
use Google2FA;
use Carbon\Carbon;



// 0x095ea7b3000000000000000000000000d00caff16b310ef3ba4b23911d83763ad766584a00000000000000000000000000000000000000000000d3c21bcecceda0000000
// 0x23b872dd4b873bc095dc0d4cee3997b11e9a815c7307abc30000000000000000000000001b4906b8140114af27c306280981d5e251f5d072000000000000000000000000000000000000000000000000000000174876e800

class WalletController extends Controller
{


    public function test() {


        $currencyData = Currency::where('id', '=', 1)->first();

        $client = new jsonRPCClient($currencyData->ip, $currencyData->port);

        // $result = $client->request('personal_unlockAccount', ["0x007bB2cb9e1e9B7a4aFB55332DDbD78E7b1611EC", "123456", '0x0a']);
        
        $result = $client->request('personal_unlockAccount', ["0xd00caff16b310ef3ba4b23911d83763ad766584a", "=cpdlsvmffjtm$%^2019", '0x0a']);
        
        

        // $mintToken  = $client->request('onlyOwner');

        dd($result);

        
        // from 문제점
        // spender 주소에도 이더가 들어있어야 함
        // sedner 주소에서 에러 발생 (Warning! Error encountered during contract execution)

        // $currencyData = Currency::where('id', '=', 1)->first();

        /*
    
        $amount = "1000";

        // 보내는 사람 주소
        $spender_addr = "0x4b873bc095dc0d4cee3997b11e9a815c7307abc3";
        $spender_pwd = $currencyData->reg_password;

        // 보내줄 사람 주소
        $sender_addr = $currencyData->address;
        $sender_pwd = $currencyData->reg_password;

        // 받을 사람 주소
        $receiver_addr = "0x1b4906b8140114af27c306280981d5e251f5d072";

        $result = $this->orc_approve($spender_addr, $spender_pwd, $sender_addr);

   

        if ($result->flag)
        {

            echo $result->message;
            $result = $this->orc_transferfrom($sender_addr, $sender_pwd, $spender_addr, $receiver_addr, $amount);

            if ($result->flag)
            echo "successed : " . $result->message . "\n";
            else
                echo "failed : " . $result->message . "\n";                        
        }
        else
        {
            echo "error : " . $result->message . "\n";
        }

        exit;
        */


        // $client = new jsonRPCClient($currencyData->ip, $currencyData->port);



        // $client = new jsonRPCClient($currencyData->ip, $currencyData->port);

        // $real_to = str_replace('0x','',$currencyData->address);
        // $real_amount = str_pad($client->dec2hex(($amount)*pow(10,$currencyData->fixed)), 64, '0', STR_PAD_LEFT);
        // // $real_amount2 = str_pad($client->dec2hex($amount * pow(10,$currency->fixed) * 10000000), 64, '0', STR_PAD_LEFT);


        // $result1 = $client->request('personal_unlockAccount', [$spender, $currencyData->reg_password, '0x0a']);

        // // print_R($result1);

        // if (isset($result1->error)) 
        // {
        //     $resultVal->message = $result1->error->message;
        //     $resultVal->flag = false;
        //     return $resultVal; 
        // }   

        // $result = $client->request('eth_sendTransaction', [[
        //     'from' => $spender,
        //     'to' => $currencyData->address,
        //     'data' => $hex_approved . $real_to . $real_amount,
        // ]]);

        // // print_r($result);

        // // 성공하면

        // $result = $this->orc_transferfrom($sender_addr, $sender_pwd, $spender_addr, $receiver_addr, $amount);


        // function orc_transferfrom($sender_addr, $sender_pwd, $from, $to, $amount)


        // $real_from = str_replace('0x','',$from);
        // $real_to = str_pad(str_replace('0x','',$to), 64, '0', STR_PAD_LEFT);
        // $real_amount = str_pad($this->dec2hex($amount*pow(10,$this->orc_digit)), 64, '0', STR_PAD_LEFT);
        
        // $result = $client->request('personal_unlockAccount', [$sender_addr, $sender_pwd, '0x0a']);
        // if (isset($result1->error)) 
        // {
        //     $resultVal->message = $result1->error->message;
        //     $resultVal->flag = false;
        //     return $resultVal; 
        // } 

        // $result = $client->request('eth_sendTransaction', [[
        //     'from' => $sender_addr,
        //     'to' => $this->orc_contractaddress,
        //     'data' => $this->hex_transferFrom . $real_from . $real_to . $real_amount,
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


        // // 거래 등록
        // $real_to = str_pad(str_replace('0x','',"0x1b4906b8140114af27c306280981d5e251f5d072"), 64, '0', STR_PAD_LEFT);
        // $real_amount = str_pad($client->dec2hex((1000)*pow(10,$currencyData->fixed)), 64, '0', STR_PAD_LEFT);
        // $result = $client->request('personal_unlockAccount', [$currencyData->address, $currencyData->password, '0x0a']);
        // $result = $client->request('eth_sendTransaction', [[
        //     'from' => $currencyData->address,
        //     'to' => $currencyData->contract,
        //     'data' => $this->funcs.$real_to.$real_amount,
        // ]]);
        // print_R($result);

        // exit;

        // 거래 조회
        // $txid = "0x089c41dad1920ced67df3eb5a35f31e789d8eef3ee9f84a1b34525ab731cf54f";
        // $s = $client->request('eth_getTransactionReceipt', [$txid]);
        // $result = $client->request('eth_getTransactionByHash', [$txid]);

        // echo "blockNumber : ".hexdec($result->result->blockNumber)."<br>";
        // // print_R($result);


        // exit;




        // $result = $client->request('eth_blockNumber');
        // $max = hexdec($result->result);
        // echo $max;
        // exit;
        

        // 싱크 조회

        // $client = new jsonRPCClient($currencyData->ip, $currencyData->port);
        // $result = $client->request('eth_syncing');

        // print_R($result);

        // echo hexdec($result->result->currentBlock)."<br>";
        // echo hexdec($result->result->highestBlock)."<br>";
        // echo hexdec($result->result->startingBlock)."<br>";
        
        
        

        // $client = new jsonRPCClient($currencyData->ip, $currencyData->port);  


        // 잔액 조회
        // $result = $client->request('eth_getBalance', ["0x4b873bc095dc0d4cEe3997b11e9a815C7307aBC3", 'latest']);
        // echo "이더 : ".hexdec($result->result)/pow(10,18)."<br>";
        
        // echo "contact : 0x099606ECb05d7E94F88EFa700225880297dD55eF <br>";
        // echo "address : 0x72331af3cd59ab4394f80fade2cec007c892a836 <br>";


        // 토큰 조회
        // $result = $client->request('eth_call', [[ 
        //     "to" => "0xa9101720da24b197589c8eaaf622e813dbf4f8c5", 
        //     "data" => "0x70a08231000000000000000000000000" . str_replace("0x","","0x4b873bc095dc0d4cee3997b11e9a815c7307abc3") ]]);
        // echo "토큰 : ".hexdec($result->result)/pow(10,8);

        return "";

    }

    public function getEthBalance($address) {

        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $client = new jsonRPCClient($currencyData->ip, $currencyData->port);

        $result = $client->request('eth_getBalance', [$address, 'latest']);
       


        $balance = hexdec($result->result)/pow(10,18);

        return $balance;
    }
    
    // 지갑 
    public function getWallet() {
        
        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $walletData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();

        
        // echo $recom_code  = uniqid('doublebet_',true);
        // exit;

        if(!$walletData) {
            Auth::logout();
            return redirect("/register");
        }


        $ethData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();


        


        // 기본 이더 지갑이 없을 경우 생성
        if(!$ethData) {

            // 기본으로 이더리움 생성
            $users_wallet = new Users_wallet;
            $users_wallet->user_id = Auth::user()->id;
            $users_wallet->currency_id = 3;
            $users_wallet->address = $walletData->address;
            $users_wallet->push();

            // 기본으로 이더리움 발란스 생성
            $balance = new Balance;
            $balance->user_id = Auth::user()->id;
            $balance->currency_id = 3;
            $balance->push();
        }

        // 추천 코드가 없으면
        if(!Auth::user()->recommender_code) {
            $user = User::find(Auth::user()->id);
            $user->recommender_code = uniqid('doublebet_');
            $user->save();
        }

       

        $balanceData = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();
        
        $ethBalance = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();
        // 서버에서 실제 이더리움 가져와서 저장
        $ethBalance->balance = $this->getEthBalance($ethData->address);
        $ethBalance->save();

        
        return view('wallet.wallet',[
            'currency' => $currencyData,
            'wallet' => $walletData,
            'balance' => $balanceData,
            'ethBalance' => $ethBalance

        ]);
    }

    // 거래 내역
    public function getHistory(Request $request) {

        $currency_id  = $request->currency_id;
        if(!$currency_id) $currency_id = env('CURRENCY_ID', '1');


        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $balanceData = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();

        $ethData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();
        $ethBalance = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();
        // 서버에서 실제 이더리움 가져와서 저장
        $ethBalance->balance = $this->getEthBalance($ethData->address);
        $ethBalance->save();


        $transactions = TransactionHistory::where('currency_id', '=', env('CURRENCY_ID', '1'))
            ->where('currency_id',$currency_id)
            ->where('user_id',Auth::user()->id)
            ->orderBy('state')->orderBy('created_at','desc')->paginate(10);

        
        $transactions->appends(
            [
                'currency_id' => $currency_id,
            ]
        );
        
        return view('wallet.history', [
            'currency' => $currencyData,
            'balance' => $balanceData,
            'currency_id' => $currency_id,
            'list' => $transactions,
            'ethBalance' => $ethBalance
        ]);

        
        
    }

    // 보내기
    public function getSend() { 

        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $balanceData = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();

        $ethData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();
        $ethBalance = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();
        // 서버에서 실제 이더리움 가져와서 저장
        $ethBalance->balance = $this->getEthBalance($ethData->address);
        $ethBalance->save();


        return view('wallet.send',[
            'currency' => $currencyData,
            'balance' => $balanceData,
            'ethBalance' => $ethBalance

        ]);
    }

    // 보내기 처리
    public function postSend(Request $request) {

        $balance = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();
        $walletData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();
        $ethData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();

        if($this->getEthBalance($ethData->address) < 0.05) {
            return back()->withErrors('There is not enough Etherium coin. ');
        }
        

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

        // 외부로 가능하게 주석처리
        // $isAddress = Users_wallet::where('address',$request->address)->count();
        // if(!$isAddress) return back()->withErrors('Invalid address.');

     
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

    // 구매
    public function getBuy() {
        $currencyData = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $balanceData = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', env('CURRENCY_ID', '1'))->first();

        $ethData = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();
        $ethBalance = Balance::where('user_id',Auth::user()->id)->where('currency_id', '=', 3)->first();
        
        // 서버에서 실제 이더리움 가져와서 저장
        $ethBalance->balance = $this->getEthBalance($ethData->address);
        $ethBalance->save();


        return view('wallet.buy',[
            'currency' => $currencyData,
            'balance' => $balanceData,
            'ethBalance' => $ethBalance

        ]);
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



curl --data '{"method":"eth_call","params":[{"to":"0x099606ECb05d7E94F88EFa700225880297dD55eF","data":"0x70a082310000000000000000000000004b873bc095dc0d4cEe3997b11e9a815C7307aBC3"}],"id":7,"jsonrpc":"2.0"}' -H "Content-Type: application/json" -X POST localhost:9101
*/

