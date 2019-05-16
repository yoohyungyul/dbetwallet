<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Cache;

use App\Currency;
use App\jsonRPCClient;
use App\Users_wallet;
use App\TransactionHistory;
use App\Balance;


class Deposit extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ether:deposit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Etherium Deposit Process.';

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
            echo "[" . date('Ymd h:i:s') . "] Work Start";

            // $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();

            $currencys = Currency::where('state','1')->where('use_rpc','2')->get();

            foreach ($currencys as $currency) {

                $client = new jsonRPCClient($currency->ip, $currency->port);


                $memory = [];
                            
                $wallets = Users_wallet::where('currency_id', $currency->id)->get();
                foreach($wallets as $wallet) {
                    $memory[] = strtolower($wallet->address);
                }


                try {
                    $result = $client->request('eth_blockNumber');
                } catch (\Exception $e) {
                    echo " Failed!\n";
                    continue;
                }

                $max = hexdec($result->result);

                $height = Cache::get('eth_last_deposit_block_'.$currency->id, 0);

                // $height = 7358065;

                if($height == 0) {
                    $height = $max-10;
                }
                $height = $height-3;
                // $height = $height-50;

             

            
                while(true) {
                    if($height > $max) {
                        break;
                    }

                    Cache::forever('eth_last_deposit_block_'.$currency->id, $height);


                    //$height = "7358062";

                    try {
                        $result = $client->request('eth_getBlockByNumber', ['0x'.$client->dec2hex($height), true]);
                        echo "  Block #".$height."...\n";

                        foreach($result->result->transactions as $txid) {

                            if(in_array(strtolower($txid->to), $memory)) {
                                $wallet = Users_wallet::where('address',$txid->to)->where('currency_id',$currency->id)->first();
                                if($wallet) {
                                    $deposit = TransactionHistory::where('currency_id',$currency->id)->where('txid',$txid->hash)->first();
                                    if(!$deposit) {

                                        echo "\n  Incomming Transaction #".$txid->hash;

                                        $balance = Balance::where('user_id',$wallet->user_id)->where('currency_id',$currency->id)->value('balance');
                                

                                        $transaction_history = new TransactionHistory;
                                        $transaction_history->type = 2;
                                        $transaction_history->user_id = $wallet->user_id;
                                        $transaction_history->currency_id = $currency->id;
                                        $transaction_history->amount = number_format((hexdec($txid->value)/pow(10,18)), $currency->fixed, '.', '');
                                        $transaction_history->balance = number_format($balance + ((hexdec($txid->value))  /pow(10,18)), $currency->fixed, '.', '');
                                        $transaction_history->txid = $txid->hash;
                                        $transaction_history->address_from = $txid->from;
                                        $transaction_history->address_to = $txid->to;
                                        $transaction_history->state = 0;
                                        $transaction_history->confirm = 0;
                                        $transaction_history->push();
                                    }
                                }
                            }


                            $token = Currency::where('use_rpc', 3)->where('state','1')->where('contract', $txid->to)->first();
                                
                            $flag = false;
                            if($token) {
                            
                                if($txid->input != '') {
                                    $hash = $txid->hash;
                                                
                                    $func = '0x'.substr($txid->input, 2, 8);
                                    // $funcs = explode(',',$token->address);
                                    // echo $txid->input;

                                    $from = "";
                                    $to = "";
                                    $amount = "";
                                    
                                    if($func == "0xa9059cbb") {
                                        $from = $txid->from;
                                        $to = '0x'.substr(substr($txid->input, 10, 64), -40);
                                        $amount = hexdec(substr($txid->input, 74, 64));
                                        
                                        $flag = true;
                                    } else if($func == "0x23b872dd") {
                                        $from = '0x'.substr(substr($txid->input, 10, 64), -40);
                                        $to = '0x'.substr(substr($txid->input, 74, 64), -40);
                                        $amount = hexdec(substr($txid->input, 138, 64));
                                        
                                        $flag = true;
                                    }
                                }
                            }

                            if($flag == true && in_array(strtolower($to), $memory)) {
                                // echo $to;
                                $wallet = Users_wallet::where('address',$to)->where('currency_id', $token->id)->first();
                                if($wallet) {
                                    $deposit = TransactionHistory::where('currency_id',$token->id)->where('txid',$txid->hash)->first();
                                    if(!$deposit) {

                                        echo "\n  Incomming Transaction #".$txid->hash;

                                        $balance = Balance::where('user_id',$wallet->user_id)->where('currency_id',$currency->id)->value('balance');
                                
                                        // echo "\n".$balance;
                                        // echo "\n".number_format(($amount/pow(10,$currency->fixed)), $currency->fixed, '.', '');
                                        // echo "\n".number_format($balance + (($amount)  /pow(10,$currency->fixed)), $currency->fixed, '.', '');
                                        // echo "\n".$txid->from;

                                        // 히스트로 등록
                                        $transaction_history = new TransactionHistory;
                                        $transaction_history->type = 2;
                                        $transaction_history->user_id = $wallet->user_id;
                                        $transaction_history->currency_id = $token->id;
                                        $transaction_history->amount = number_format(($amount/pow(10,$token->fixed)), $token->fixed, '.', '');
                                        $transaction_history->balance = number_format($balance + (($amount)  /pow(10,$token->fixed)), $token->fixed, '.', '');
                                        $transaction_history->txid = $txid->hash;
                                        $transaction_history->address_from = $txid->from;
                                        $transaction_history->address_to = $to;
                                        $transaction_history->state = 0;
                                        $transaction_history->confirm = 0;
                                        $transaction_history->push();

                                    }
                                }
                            }
                        }

                        $height++;
                        echo "  Done!\n";
                    } catch(\Exception $e) {
                        echo "  Retry...".$e->getMessage()."\n";
                        
                        sleep(10);
                    }

                            
                    usleep(10000);
                }

                echo " Done!\n";
                
                
            }

            echo "\n[" . date('Ymd h:i:s') . "] Work End\n";
                
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

}
