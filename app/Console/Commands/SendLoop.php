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

        $history = TransactionHistory::where('txid','')->orderBy('id','asc')->get();

        foreach($history as $data) {

            $client = new jsonRPCClient($currency->ip, $currency->port);
            
            $funcs = "0xa9059cbb";

            $real_to = str_pad(str_replace('0x','',$data->address_to), 64, '0', STR_PAD_LEFT);
            $real_amount = str_pad($client->dec2hex(($data->amount)*pow(10,$currency->fixed)), 64, '0', STR_PAD_LEFT);
            
            $result = $client->request('personal_unlockAccount', ["0x007bB2cb9e1e9B7a4aFB55332DDbD78E7b1611EC", "123456", '0x0a']);
            $result = $client->request('eth_sendTransaction', [[
                'from' => "0x007bB2cb9e1e9B7a4aFB55332DDbD78E7b1611EC",
                'to' => "0x099606ECb05d7E94F88EFa700225880297dD55eF",
                'data' => $funcs.$real_to.$real_amount,
            ]]);

            print_R($result);


            

          //  echo $data->id;

        }

    }

}
