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
        $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();

        $history = TransactionHistory::where('txid','')->where('state','0')->orderBy('id','asc')->get();

        $client = new jsonRPCClient($currency->ip, $currency->port);

        $result = $client->request('personal_unlockAccount', ["0x1b4906b8140114af27c306280981d5e251f5d072", "123456", '0x0a']);

        print_R($result);
        exit;

        // echo "이더 : ".hexdec("0x640b5eece000")/pow(10,8);
        
        // exit;

        foreach($history as $data) {

            $client = new jsonRPCClient($currency->ip, $currency->port);
            
            $funcs = "0xa9059cbb";

            $real_to = str_pad(str_replace('0x','',$data->address_to), 64, '0', STR_PAD_LEFT);
            $real_amount = str_pad($client->dec2hex(($data->amount)*pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);


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


            
            $result = $client->request('personal_unlockAccount', ["0x1b4906b8140114af27c306280981d5e251f5d072", "123456", '0x0a']);
            // $result = $client->request('eth_sendTransaction', [[
            //     'from' => "0x1b4906b8140114af27c306280981d5e251f5d072",
            //     'to' => "0x099606ECb05d7E94F88EFa700225880297dD55eF",
            //     'data' => $funcs.$real_to.$real_amount,
            // ]]);

            // print_R($result);


            

          //  echo $data->id;

        }

    }

}
