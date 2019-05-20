<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Cache;
use Log;
use App\TransactionHistory;
use App\Currency;
use App\jsonRPCClient;
use App\Users_wallet;
use App\Balance;
use App\BuyHistory;

class WalletConfirm extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '토큰 보내기 받기 업데이트.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {


        while (true) {

            echo "\n[" . date('Ymd h:i:s') . "] Work Start\n";
            
            // $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();


            $currencys = Currency::where('state','1')->get();

            foreach ($currencys as $currency) {


                $client = new jsonRPCClient($currency->ip, $currency->port);
                
                // 보내기 루프 
                $history = TransactionHistory::where('txid','!=','')->where('currency_id',$currency->id)->where('state','0')->orderBy('id','asc')->get();
                foreach ($history as $history) {


                
                    try {
                    
                        $s = $client->request('eth_getTransactionReceipt', [$history->txid]);
                        $result = $client->request('eth_getTransactionByHash', [$history->txid]);

                    
                        // if ($result->result != '' && $s->result->status != '0') {
                        if(is_object($result)) {
            
                            if ($result->result->blockNumber != null && $result->result->blockNumber != '') {

                                $current_block = $result->result->blockNumber;

                            
                                
                                $result2 = $client->request('eth_blockNumber');
                                if ($result2->result != '') {
                                    $current_block = $result2->result;
                                }

                                
                                if(hexdec($current_block) - hexdec($result->result->blockNumber) > $history->confirm) {


                                    try {
                                        DB::beginTransaction();
                                    

                                        $history->confirm = hexdec($current_block) - hexdec($result->result->blockNumber);
                                        $history->state = 1;
                                        $history->save();


                                        // DBET
                                        if($currency->id == "2") {
                                            $balance = $this->getDbetBalance($history->user_id);
                                        // ETH
                                        } else if($currency->id == "3") {
                                            $balance = $this->getEthBalance($history->user_id);
                                        }

                                        // 보내기
                                        if($history->type == 1) {
                                            // 받는 사람 주소를 조회 후 있으면 등록 
                                            $to_userid = Users_wallet::where('address',$history->address_to)->value('user_id');
                                            if($to_userid) {
                                                // 받는 사람 발란스 가져오기
                                                // $to_user_balance = Balance::where('user_id',$to_userid)->where('currency_id',$currency->id)->first();

                                                // // 발란스 업데이트
                                                // $to_user_balance->balance += $history->amount;
                                                // $to_user_balance->save();

                                                // DBET
                                                if($currency->id == "2") {
                                                    $balance = $this->getDbetBalance($to_userid);
                                                // ETH
                                                } else if($currency->id == "3") {
                                                    $balance = $this->getEthBalance($to_userid);
                                                }
                                                
                                                // 히스트로 등록
                                                $transaction_history = new TransactionHistory;
                                                $transaction_history->type = 2;
                                                $transaction_history->user_id = $to_userid;
                                                $transaction_history->currency_id = $currency->id;
                                                $transaction_history->buy_id = $history->buy_id;
                                                $transaction_history->amount = $history->amount;
                                                $transaction_history->balance = $balance;
                                                $transaction_history->txid = $history->txid;
                                                $transaction_history->address_from = $history->address_from;
                                                $transaction_history->address_to = $history->address_to;
                                                $transaction_history->state = $history->state;
                                                $transaction_history->confirm = $history->confirm;
                                                $transaction_history->push();

                                            } else {
                                                echo "No User Address";
                                            }
                                            
                                            // 구매이면
                                            if($history->buy_id) {
                                                $buyData = BuyHistory::where('id',$history->buy_id)->first();
                                                if($buyData) {
                                                    $buyData->state = $buyData->state + 1;
                                                    $buyData->push();
                                                }

                                            }
                                        }

                                    } catch (\Exception $e) {
                                        DB::rollback();

                                        echo " DB Error ";
                                    } finally {
                                        DB::commit();

                                        echo " send Complete!";
                                    }

                                    
                                } else {
                                    
                                    
                                    $history->history = hexdec($current_block) - hexdec($result->result->blockNumber);
                                    $history->save();

                                    echo " send Pending!";
                                }

                            } else {
                                echo " No Block Number!";
                            }
                        } else {
                            echo " RPC Error!";
                        }
                    
                    } catch(\Exception $e) {
                        echo " No RPC!";
                    }

                    echo "\n";
                }

                echo " Done!\n";
            }
            echo "[" . date('Ymd h:i:s') . "] Work End\n";

            sleep(60);
        }
    }

    public function base64pwd_encode($data) 
    { 
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 
      
    public function base64pwd_decode($data) 
    { 
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }


    public function getDbetBalance($id) {


        $walletData = Users_wallet::where('user_id',$id)->where('currency_id', '=', 2)->first();

        $currencyData = Currency::where('id', '=', 2)->first();
        $client = new jsonRPCClient($currencyData->ip, $currencyData->port);

         // 토큰 조회
        $result = $client->request('eth_call', [[ 
            "to" => $currencyData->contract, 
            "data" => "0x70a08231000000000000000000000000" . str_replace("0x","",$walletData->address) ]]);
        $balance  = hexdec($result->result)/pow(10,8);

        $balanceData = Balance::where('user_id',$id)->where('currency_id', '=', 2)->first();
        $balanceData->balance = $balance;
        $balanceData->push();

        // 남은 잔액
        $dbetBalance = $balanceData->balance;

        return $dbetBalance;

    }

    public function getEthBalance($id) {

        // 서버에서 직접 조회
        $walletData = Users_wallet::where('user_id',$id)->where('currency_id', '=', 3)->first();


        $currencyData = Currency::where('id', '=', 3)->first();
        $client = new jsonRPCClient($currencyData->ip, $currencyData->port);
        $result = $client->request('eth_getBalance', [$walletData->address, 'latest']);
        $balance = hexdec($result->result)/pow(10,18);


        $balanceData = Balance::where('user_id',$id)->where('currency_id', '=', 3)->first();
        $balanceData->balance = $balance;
        $balanceData->push();

        // 남은 잔액
        $ethBalance = $balanceData->balance;

        return $ethBalance;

       
    }

}
