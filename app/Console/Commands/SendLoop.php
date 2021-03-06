<?php

namespace App\Console\Commands;

use Cache;
use DB;

use App\TransactionHistory;
use App\BuyHistory;
use App\Currency;
use App\jsonRPCClient;


use Illuminate\Console\Command;

class SendLoop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:loop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '보내기 루프 실행 .';


    protected $hex_getbalance           = '0x70a08231';
    protected $hex_sendTransaction      = '0xa9059cbb';
    protected $hex_approved             = '0x095ea7b3';
    protected $hex_transferFrom         = '0x23b872dd';

    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        while (true) {

            echo "[" . date('Ymd h:i:s') . "] Work Start\n";

            $currencys = Currency::where('state','1')->get();

            foreach ($currencys as $currency) {

                // 보낸 목록
                $history = TransactionHistory::where('txid','')->where('currency_id',$currency->id)->where('type','1')->where('state','0')->orderBy('id','asc')->get();

                

                $client = new jsonRPCClient($currency->ip, $currency->port);

                
                

                foreach($history as $data) {

                    // 토큰
                    if ($currency->use_rpc == 1) {

                        $funcs = "0xa9059cbb"; 

                        // 이더리움 잔액 검색
                        $result = $client->request('eth_getBalance', [$data->address_from, 'latest']);
                        $balance = hexdec($result->result)/pow(10,18);

                        if($balance < 0.05) {
                            echo "There is not enough Etherium coin.";
                        } else {
                            $real_to = str_pad(str_replace('0x','',$data->address_to), 64, '0', STR_PAD_LEFT);
                            $real_amount = str_pad($client->dec2hex(($data->amount)*pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);


                            $result = $client->request('personal_unlockAccount', [$data->address_from, $currency->reg_password, '0x0a']);


                            
                            $result = $client->request('eth_sendTransaction', [[
                                'from' => $data->address_from,
                                'to' => $currency->contract,
                                'data' => $funcs.$real_to.$real_amount,
                            ]]);


                            if(is_object($result)) {

                                if ($result->result != '') {
                                    try {
                                        DB::beginTransaction();
                                        
                                        $data->txid = $result->result;
                                        $data->push();
                                        
                                    
                                        echo " Update Complete!";
                                    } catch (\Exception $e) {
                                        DB::rollback();

                                        echo " Update Failed!";
                                    } finally {
                                        DB::commit();
                                    }
                                } 
                            } else {
                                echo " RPC Error!";
                            }
                        }
                    // 이더
                    } else if($currency->use_rpc == 2) {
                        
                        $result = $client->request('personal_unlockAccount', [$data->address_from, $currency->reg_password, '0x0a']);
                        $result = $client->request('eth_sendTransaction', [[
                            'from' => $data->address_from,
                            'to' => $data->address_to,
                            'value' => '0x'.$client->dec2hex(number_format($data->amount , $currency->fixed, '.', '')*pow(10,18)),
                        ]]);


                        if(is_object($result)) {

                            if ($result->result != '') {
                                try {
                                    DB::beginTransaction();
                                    
                                    $data->txid = $result->result;
                                    $data->push();
                                    
                                
                                    echo " Update Complete!";
                                } catch (\Exception $e) {
                                    DB::rollback();

                                    echo " Update Failed!";
                                } finally {
                                    DB::commit();
                                }
                            } 
                        } else {
                            echo " RPC Error!";

                            $historyData = TransactionHistory::where('id',$data->id)->first();
                            if($historyData) {
                                $historyData->state = 2;
                                $historyData->push();
                            }

                            if($data->buy_id) {

                                $buyData = BuyHistory::where('id',$data->buy_id)->first();
                                $buyData->state = 6;
                                $buyData->push();
                            }
                        }

                       

                    }
                    echo "\n";

                }
            }

            echo "[" . date('Ymd h:i:s') . "] Work End\n";
            sleep(60);
        }

    }
}



/*


0x0088f6def20b7cc6c0b02556ed11152e133ae580471c509536414f48a232e988



0x0e70b6f918f22adb1d7693bf33e7d3df46be2be4fd33843a56fbbb9809e5fc69



// $result = $client->request('personal_unlockAccount', ["0xe01c3f87166D035EF915116FD27B48Ae7D3543D7", "123456", '0x0a']);
// print_R($result);

    // 이더 조회
// $result = $client->request('eth_getBalance', ["0x0D3183F579F6f5b28C60B09bD20A696bC80BF15b", 'latest']);
// echo "이더 : ".hexdec($result->result)/pow(10,8);

// curl -X POST --data '{"jsonrpc":"2.0","method":"eth_getBalance","params":["0x1B4906B8140114aF27c306280981d5e251f5D072", "latest"],"id":1}' -H "Content-Type: application/json" -X POST localhost:9101


// // 토큰 조회
// $result = $client->request('eth_call', [[ 
//  "to" => "0x099606ECb05d7E94F88EFa700225880297dD55eF", 
//  "data" => "0x70a08231000000000000000000000000". str_replace("0x","","0x0D3183F579F6f5b28C60B09bD20A696bC80BF15b") ]]);
// echo "토큰 : ".hexdec($result->result)/pow(10,8);



// $result = $client->request('personal_unlockAccount', ["0x1b4906b8140114af27c306280981d5e251f5d072", "123456", '0x0a']);
// $result = $client->request('eth_sendTransaction', [[
//     'from' => "0x1b4906b8140114af27c306280981d5e251f5d072",
//     'to' => "0x099606ECb05d7E94F88EFa700225880297dD55eF",
//     'data' => $funcs.$real_to.$real_amount,
// ]]);

// print_R($result);




//  echo $data->id;

*/


            // try {

            


            // // 이더 조회
            // $result = $client->request('eth_getBalance', ["0x1b4906b8140114af27c306280981d5e251f5d072", 'latest']);
            // echo "이더 : ".hexdec($result->result)."\n";

            // // // 토큰 조회
            // $result = $client->request('eth_call', [[ 
            // "to" => "0x099606ECb05d7E94F88EFa700225880297dD55eF", 
            // "data" => "0x70a08231000000000000000000000000". str_replace("0x","","0x1b4906b8140114af27c306280981d5e251f5d072") ]]);
            // echo "토큰 : ".hexdec($result->result)."\n";

