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

            echo $max;

            
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
