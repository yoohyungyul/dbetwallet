<?php

namespace App\Console\Commands;

use Cache;
use DB;

use App\TransactionHistory;
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
            $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();

            // 보낸 목록
            $history = TransactionHistory::where('txid','')->where('type','1')->where('currency_id',env('CURRENCY_ID', '1'))->where('state','0')->orderBy('id','asc')->get();

            $funcs = "0xa9059cbb";
            // $from  = '0x23b872dd000000000000000000000000';

            $client = new jsonRPCClient($currency->ip, $currency->port);

            
            

            foreach($history as $data) {

                // 이걸 먼저 해서
                // orc_approve($spender_addr, $spender_pwd, $sender_addr);

                // $real_from = str_replace('0x','',$data->address_from);
                // $real_from = str_pad(str_replace('0x','',$data->address_from), 64, '0', STR_PAD_LEFT);
                $real_to = str_pad(str_replace('0x','',$data->address_to), 64, '0', STR_PAD_LEFT);
                $real_amount = str_pad($client->dec2hex(($data->amount)*pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);


                $result = $client->request('personal_unlockAccount', [$currency->address, $currency->password, '0x0a']);


                // $result = $this->approve($data->address_from, $data->amount , $currency);

                // print_R($result);

                // exit;


                
                $result = $client->request('eth_sendTransaction', [[
                    'from' => $currency->address,
                    'to' => $currency->contract,
                    'data' => $funcs.$real_to.$real_amount,
                ]]);


                // $result = $client->request('eth_sendTransaction', [[
                //     'from' => $currency->address,
                //     'to' => $currency->contract,
                //     'data' => $from . $real_from . $real_to . $real_amount,
                // ]]);




                // print_R($result);
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

                echo "\n";

            }

            echo "[" . date('Ymd h:i:s') . "] Work End\n";
            sleep(60);
        }

    }

    function transferfrom($sender_addr, $sender_pwd, $from, $to, $amount)
    {
        $resultVal = (object) [
            'message' => "",
            'flag' => false
        ];  

        try 
        {
            $client = new jsonORCRPCClient($this->rpcserver_ip, $this->rpcserver_port);         

            //$real_from = str_pad(str_replace('0x','',$from), 64, '0', STR_PAD_LEFT);
            $real_from = str_replace('0x','',$from);
            $real_to = str_pad(str_replace('0x','',$to), 64, '0', STR_PAD_LEFT);
            $real_amount = str_pad($this->dec2hex($amount*pow(10,$this->orc_digit)), 64, '0', STR_PAD_LEFT);
            
            $result = $client->request('personal_unlockAccount', [$sender_addr, $sender_pwd, '0x0a']);
            if (isset($result1->error)) 
            {
                $resultVal->message = $result1->error->message;
                $resultVal->flag = false;
                return $resultVal; 
            } 

            $result = $client->request('eth_sendTransaction', [[
                'from' => $sender_addr,
                'to' => $this->orc_contractaddress,
                'data' => $this->hex_transferFrom . $real_from . $real_to . $real_amount,
            ]]);

            //print_r($result);
            if (isset($result->result)) 
            {
                $resultVal->message = $result->result;
                $resultVal->flag = true;
            } 
            else if (isset($result->error)) 
            {
                $resultVal->message = $result->error->message;
                $resultVal->flag = false;
            }           
        }
        catch(\Exception $e) 
        {
            $resultVal->message = "RPC Server Error";
            $resultVal->flag = false;
        }

        return $resultVal;               
    }



    function approve($spender, $amount ,$currency)
    {

        $resultVal = (object) [
            'message' => "",
            'flag' => false
        ];  

        $client = new jsonRPCClient($currency->ip, $currency->port); 


        $real_to = str_replace('0x','',$currency->address);
        $real_amount = str_pad($client->dec2hex(($amount)*pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);
        // $real_amount2 = str_pad($client->dec2hex($amount * pow(10,$currency->fixed) * 10000000), 64, '0', STR_PAD_LEFT);

        

            
        
        $result1 = $client->request('personal_unlockAccount', [$spender, $currency->reg_password, '0x0a']);

        if (isset($result1->error)) 
        {
            $resultVal->message = $result1->error->message;
            $resultVal->flag = false;
            return $resultVal; 
        }   

        $result = $client->request('eth_sendTransaction', [[
            'from' => $spender,
            'to' => $currency->address,
            'data' => $this->hex_approved . $real_to . $real_amount,
        ]]);

        print_r($result);


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

