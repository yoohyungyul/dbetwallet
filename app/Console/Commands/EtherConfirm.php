<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Cache;
use Log;
use App\TransactionHistory;

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

        echo "\n[" . date('Ymd h:i:s') . "] Work Start\n";
        
                
          
            // 보내기 루프 
            $history = TransactionHistory::where('txid','!=','')->where('type','1')->where('state','0')->orderBy('id','asc')->get();
            foreach ($withdrawals as $withdrawal) {

                echo "1";
            }
            // foreach ($withdrawals as $withdrawal) {
            //     echo "\n Trying Update T".$token->id."W#" . $withdrawal->id . "...";

            //     try {
            //         $s = $client->request('eth_getTransactionReceipt', [$withdrawal->txid]);
            //         $result = $client->request('eth_getTransactionByHash', [$withdrawal->txid]);
            //         if ($result->result != '' && $s->result->status != '0') {
            //             if ($result->result->blockNumber != null && $result->result->blockNumber != '') {
            //                 $current_block = $result->result->blockNumber;
                            
            //                 $result2 = $client->request('eth_blockNumber');
            //                 if ($result2->result != '') {
            //                     $current_block = $result2->result;
            //                 }
                            
            //                 if(hexdec($current_block) - hexdec($result->result->blockNumber) > $token->confirm) {
            //                     echo " Withdrawal Complete!";

            //                     $withdrawal->confirm = hexdec($current_block) - hexdec($result->result->blockNumber);
            //                     $withdrawal->state = 1;

            //                     $withdrawal->save();

            //                     /* 출금 완료 후 외부 입금 분리해서 저장 Start */
                            
            //                     $isWithdrawalCount = WithdrawalOutSide::where('txid',$withdrawal->txid)->count();
            //                     if(!$isWithdrawalCount) {
            //                         $withdrawalOutSide = new WithdrawalOutSide;
            //                         $withdrawalOutSide->user_id = $withdrawal->user_id;
            //                         $withdrawalOutSide->currency_id = $withdrawal->currency_id;
            //                         $withdrawalOutSide->amount = $withdrawal->amount;
            //                         $withdrawalOutSide->fee = $withdrawal->fee;
            //                         $withdrawalOutSide->fee_type = $withdrawal->fee_type;
            //                         $withdrawalOutSide->address = $withdrawal->address;
            //                         $withdrawalOutSide->txid = $withdrawal->txid;
            //                         $withdrawalOutSide->confirm = $withdrawal->confirm;
            //                         $withdrawalOutSide->state = $withdrawal->state;
            //                         $withdrawalOutSide->message = $withdrawal->message;
            //                         $withdrawalOutSide->created_at = $withdrawal->created_at;
            //                         $withdrawalOutSide->updated_at = $withdrawal->updated_at;
            //                         $withdrawalOutSide->save();
            //                     }
                                
            //                     /* 출금 완료 후 외부 입금 분리해서 저장 End */
            //                 } else {
            //                     echo " Withdrawal Pending!";
                                
            //                     $withdrawal->confirm = hexdec($current_block) - hexdec($result->result->blockNumber);

            //                     $withdrawal->save();
            //                 }
            //             } else {
            //                 echo " No Block Number!";
            //             }
            //         } else {
            //             echo " RPC Error!";
            //         }
            //     } catch(\Exception $e) {
            //         echo " No RPC!";
            //     }
            // }

            // echo "\n[" . date('Ymd h:i:s') . "] Work End\n";
          
       
        //}
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
