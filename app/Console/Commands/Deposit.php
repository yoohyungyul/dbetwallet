<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Cache;

use App\Currency;
use App\jsonRPCClient;


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

            $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();

            $client = new jsonRPCClient($currency->ip, $currency->port);

            try {
                $result = $client->request('eth_blockNumber');
            } catch (\Exception $e) {
                echo " Failed!\n";
                continue;
            }

            $max = hexdec($result->result);

            $height = Cache::get('eth_last_deposit_block_'.$currency->id, 0);

            echo $height;
            exit;
            if($height == 0) {
                $height = $max-100;
            }
            $height = $height-3;

            // echo $height;

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
                        
                        $flag = false;
                        if($txid->input != '') {
                            $hash = $txid->hash;
                                        
                            $func = '0x'.substr($txid->input, 2, 8);
                            // $funcs = explode(',',$token->address);
                            // echo $txid->input;
                            
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

                           

                            // if($flag == true && in_array(strtolower($to), $memory)) {
                                // echo $to;
                                // $wallet = Wallet::where('address',$to)->first();
                                // if($wallet) {
                                //     $deposit = Deposit::where('currency_id',$token->id)->where('txid',$txid->hash)->first();
                                //     if(!$deposit) {
                                //         echo "\n  Incomming Transaction #".$txid->hash;
                                        
                                //         $first = Deposit::where('currency_id',$token->id)->where('user_id',$wallet->user_id)->where('txid','NOT LIKE','system%')->first();
                                //         if(!$first) {
                                //             echo " NEW!";
                                //             $result = $client->request('personal_unlockAccount', [$currency->password, $hot_password, '0x0a']);
                                //             $result = $client->request('eth_sendTransaction', [[
                                //                 'from' => $currency->password,
                                //                 'to' => $to,
                                //                 'value' => '0x'.$client->dec2hex((0.02)*pow(10,18)),
                                //             ]]);
                                //             Log::info($result->result);
                                //         }
                                        
                                //         $deposit = new Deposit;

                                //         $deposit->user_id = $wallet->user_id;
                                //         $deposit->currency_id = $token->id;
                                //         $deposit->amount = number_format(($amount/pow(10,$token->fixed)), $token->fixed, '.', '');
                                //         $deposit->fee = 0;
                                //         $deposit->address = $to;
                                //         $deposit->txid = $txid->hash;
                                //         $deposit->confirm = 0;
                                //         $deposit->state = 0;
                                //         $deposit->message = 'a,'.$txid->from;

                                //         $deposit->save();
                                //     }
                                // }
                            // }
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
            
            echo "\n[" . date('Ymd h:i:s') . "] Work End\n";
			
			sleep(10);
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
