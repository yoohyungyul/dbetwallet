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

use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;


class Google2FAController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        //
    }


    public function getQRCodeInline($company, $holder, $secret, $size = 200, $encoding = 'utf-8')
    {
        $url = $this->getQRCodeUrl($company, $holder, $secret);

        $renderer = new Png();
        $renderer->setWidth($size);
        $renderer->setHeight($size);

        $writer = new Writer($renderer);
        $data = $writer->writeString($url, $encoding);

        return 'data:image/png;base64,'.base64_encode($data);
    }

    /**
     * Creates a QR code url.
     *
     * @param $company
     * @param $holder
     * @param $secret
     *
     * @return string
     */
    public function getQRCodeUrl($company, $holder, $secret)
    {
        return 'otpauth://totp/'.rawurlencode($company).':'.rawurlencode($holder).'?secret='.$secret.'&issuer='.rawurlencode($company).'';
    }



    public function enableTwoFactor()
    {
        
        if (Auth::user()->google2fa_secret) {
            return redirect('wallet');
        }
        
        $secret = $this->generateSecret();
        
        Session::put('2fa:store:id', Auth::user()->id);
        Session::put('2fa:store:key', $secret);


        $imageDataUri = $this->getQRCodeInline(env('APP_DOMAIN'), Auth::user()->email, $secret, 200);





        // $imageDataUri = env('APP_DOMAIN').Auth::user()->email.",".$secret;

        
        

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
            return back()->withErrors('This is the OTP code already used.');
        }
        
        $verify = false;
        try {
            $verify = Google2FA::verifyKey($session_key, $request->totp);
        } catch (\Exception $e) {
            $verify = false;
        }

        if(!$verify) {
            return back()->withErrors('OTP code mismatch.');
        }
        
        if ($session_id == Auth::user()->id) {

            try {
                DB::beginTransaction();

                $user = Auth::user();
                $user->google2fa_secret = $session_key;
                $user->save();


                $currency = Currency::where('id', '=', env('CURRENCY_ID', '1'))->first();

                $wallet = Users_wallet::where('user_id',Auth::user()->id)->where('currency_id',env('CURRENCY_ID', '1'))->first();
                
                if(!$wallet) {
                    // 지갑 생성
                    $params = array($currency->reg_password);
                    $client = new jsonRPCClient($currency->ip, $currency->port);
                    $result = $client->request('personal_newAccount', $params);
                    $address = $result->result;


                    $users_wallet = new Users_wallet;
                    $users_wallet->user_id = Auth::user()->id;
                    $users_wallet->currency_id = env('CURRENCY_ID', '1');
                    $users_wallet->address = $address;
                    $users_wallet->push();

                    // 기본으로 이더리움 생성
                    $users_wallet = new Users_wallet;
                    $users_wallet->user_id = Auth::user()->id;
                    $users_wallet->currency_id = 3;
                    $users_wallet->address = $address;
                    $users_wallet->push();


            
                    // balance 생성
                    $balance = new Balance;
                    $balance->user_id = Auth::user()->id;
                    $balance->currency_id = env('CURRENCY_ID', '1');
                    $balance->push();

                    // 기본으로 이더리움 발란스 생성
                    $balance = new Balance;
                    $balance->user_id = Auth::user()->id;
                    $balance->currency_id = 3;
                    $balance->push();
                }



            } catch (\Exception $e) {
                DB::rollback();
    
                return back()->withErrors('Oops, database error is occurred!');
    
               
            } finally {
                DB::commit();
            }
            
            return redirect('wallet')->with('message', '2-step verification has been applied.');;
        }
        
        return back()->withErrors('Unknown error.');
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

            if(!$user->google2fa_secret) {

                $name = "chainplus";
                $value = $user->wallet_code;
                $minutes = time()+60*60*24*365;

                Cookie::queue($name, $value, $minutes);

                if(!Auth::check()) Auth::login($user);


                return redirect("/2fa/enable");
            }

            if(Cache::has($key)) {
                return back()->withErrors('This is the OTP code already used.');
            }

            if(!Google2FA::verifyKey($user->google2fa_secret, $request->totp)) {
                return back()->withErrors('OTP code mismatch.');
            }



            $name = "chainplus";
            $value = $user->wallet_code;
            $minutes = time()+60*60*24*365;

            Cookie::queue($name, $value, $minutes);


            return redirect('wallet');



        } else {
            return back()->withErrors('No matching emails.');
        }

        exit;
    }
}