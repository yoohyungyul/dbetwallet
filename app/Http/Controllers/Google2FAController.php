<?php

namespace App\Http\Controllers;

use DB;
use Cache;
use Auth;
use Session;
use Validator;
use Google2FA;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;

use App\User;
use App\Currency;
use App\jsonRPCClient;
use App\Balance;
use App\Users_wallet;
use Cookie;




class Google2FAController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        //
    }

    public function enableTwoFactor()
    {
        if (Auth::user()->google2fa_secret) {
            return redirect('wallet');
        }
        
        $secret = $this->generateSecret();
        
        Session::put('2fa:store:id', Auth::user()->id);
        Session::put('2fa:store:key', $secret);

        $imageDataUri = Google2FA::getQRCodeInline(env('APP_DOMAIN'), Auth::user()->name, $secret, 200);

        return view('2fa/enableTwoFactor', ['image' => $imageDataUri, 'secret' => $secret]);
    }
    
    public function storeTwoFactor(Request $request)
    {
        if (Auth::user()->google2fa_secret) {
            return redirect('wallet');
        }
        
        $session_id = Session::get('2fa:store:id', null);
        $session_key = Session::get('2fa:store:key', null);
        Session::forget('2fa:store:id');
        Session::forget('2fa:store:key');
        
        $validator = Validator::make($request->all(), [
            'totp' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        
        if(Cache::has(Auth::user()->id . ':' . $request->totp)) {
            return back()->withErrors([trans('google2fa.error_used')]);
        }
        
        $verify = false;
        try {
            $verify = Google2FA::verifyKey($session_key, $request->totp);
        } catch (\Exception $e) {
            $verify = false;
        }

        if(!$verify) {
            return back()->withErrors([trans('google2fa.error_not_valid')]);
        }
        
        if ($session_id == Auth::user()->id) {

            try {
                DB::beginTransaction();

                $user = Auth::user();
                $user->google2fa_secret = $session_key;
                $user->save();


                $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();

                // 지갑 생성
                $params = array($currency->password);
                $client = new jsonRPCClient($currency->ip, $currency->port);
                $result = $client->request('personal_newAccount', $params);
                $address = $result->result;


                $users_wallet = new Users_wallet;
                $users_wallet->user_id = Auth::user()->id;
                $users_wallet->currency_id = env('CURRENCY_ID', '1');
                $users_wallet->address = $address;
                $users_wallet->push();
        
                // balance 생성
                $balance = new Balance;
                $balance->user_id = Auth::user()->id;
                $balance->currency_id = env('CURRENCY_ID', '1');
                $balance->push();

            } catch (\Exception $e) {
                DB::rollback();
    
                return back()->withErrors('Oops, database error is occurred!');
    
               
            } finally {
                DB::commit();
            }
            
            return redirect('wallet')->with('message', trans('google2fa.success'));;
        }
        
        return back()->withErrors([trans('google2fa.error_unknown')]);
    }

    private function generateSecret()
    {
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }

    public function getLogin() {
        return view('2fa/login');
    }

    public function postLogin(Request $request) {

        $user = User::where('email',$request->email)->first();

        if($user) {

            $key = $user->id . ':' . $request->totp;

            if(Cache::has($key)) {
                return back()->withErrors('This is the OTP code already used.');
            }

            if(!Google2FA::verifyKey($user->google2fa_secret, $request->totp)) {
                return back()->withErrors('OTP code mismatch.');
            }


            $name = "chaninplus";
            $value = $user->wallet_code;
            $minutes = time()+60*60*24*365;;

            Cookie::queue($name, $value, $minutes);


            return redirect('wallet');



        } else {
            return back()->withErrors('일치하는 이메일이 없습니다.');
        }

        exit;
    }
}