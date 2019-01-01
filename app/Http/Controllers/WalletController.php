<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WalletController extends Controller
{
    public function getWallet() {
        return view('wallet.wallet');
    }
}
