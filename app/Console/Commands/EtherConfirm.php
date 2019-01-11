<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Cache;
use Log;
use App\TransactionHistory;
use App\Currency;
use App\jsonRPCClient;

class EtherConfirm extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ether:confirm';

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


        $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();
        $client = new jsonRPCClient($currency->ip, $currency->port);

        echo "\n[" . date('Ymd h:i:s') . "] Work Start\n";
        
                
          
        // 보내기 루프 
        $history = TransactionHistory::where('txid','!=','')->where('type','1')->where('state','0')->orderBy('id','asc')->get();
        foreach ($history as $history) {
           
           

               
                $s = $client->request('eth_getTransactionReceipt', [$history->txid]);
                $result = $client->request('eth_getTransactionByHash', [$history->txid]);

                print_R($result);

                if ($result->result != '' && $s->result->status != '0') {
                    echo "1";
                //     if ($result->result->blockNumber != null && $result->result->blockNumber != '') {

                //         $current_block = $result->result->blockNumber;
                        
                //         $result2 = $client->request('eth_blockNumber');
                //         if ($result2->result != '') {
                //             $current_block = $result2->result;
                //         }
                        
                //         if(hexdec($current_block) - hexdec($result->result->blockNumber) > $token->confirm) {
                //             echo " send Complete!";

                //             $history->confirm = hexdec($current_block) - hexdec($result->result->blockNumber);
                //             $history->state = 1;

                //             $history->save();
                            
                //         } else {
                //             echo " send Pending!";
                            
                //             $history->history = hexdec($current_block) - hexdec($result->result->blockNumber);

                //             $history->save();
                //         }

                //     } else {
                //         echo " No Block Number!";
                //     }
                } else {
                    echo " RPC Error!";
                }
                                



            echo "\n";
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
