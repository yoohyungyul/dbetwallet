<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WalletController extends Controller
{
    // 지갑 
    public function getWallet() {
        return view('wallet.wallet');
    }

    // 거래 내역
    public function getHistory() {

        return view('wallet.history');
    }

    // 보내기
    public function getSend() {

        return view('wallet.send');
    }
}
