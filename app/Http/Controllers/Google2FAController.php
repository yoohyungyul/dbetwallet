<?php

namespace App\Http\Controllers;

use Cache;
use Auth;
use Session;
use Validator;
use Google2FA;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;

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
            $user = Auth::user();
            $user->google2fa_secret = $session_key;
            $user->save();
            
            return redirect('wallet')->with('message', trans('google2fa.success'));;
        }
        
        return back()->withErrors([trans('google2fa.error_unknown')]);
    }

    private function generateSecret()
    {
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }
}