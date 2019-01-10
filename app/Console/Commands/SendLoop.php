<?php

namespace App\Console\Commands;

use Cache;
use DB;

use App\TransactionHistory;
use App\Currency;



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

        echo $currency->id;

        $history = TransactionHistory::where('txid','')->orderBy('id','asc')->get();

        foreach($history as $data) {

          //  echo $data->id;

        }

    }

}
