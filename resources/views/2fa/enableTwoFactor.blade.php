@extends('layouts.master')

@section('content')
<style>
.mt-0,.my-0{margin-top:0 !important;}
.mr-0,.mx-0{margin-right:0 !important;}
.mb-0,.my-0{margin-bottom:0 !important;}
.ml-0,.mx-0{margin-left:0 !important;}
.m-1{margin:0.25rem !important;}
.mt-1,.my-1{margin-top:0.25rem !important;}
.mr-1,.mx-1{margin-right:0.25rem !important;}
.mb-1,.my-1{margin-bottom:0.25rem !important;}
.ml-1,.mx-1{margin-left:0.25rem !important;}
.m-2{margin:0.5rem !important;}
.mt-2,.my-2{margin-top:0.5rem !important;}
.mr-2,.mx-2{margin-right:0.5rem !important;}
.mb-2,.my-2{margin-bottom:0.5rem !important;}
.ml-2,.mx-2{margin-left:0.5rem !important;}
.m-3{margin:1rem !important;}
.mt-3,.my-3{margin-top:1rem !important;}
.mr-3,.mx-3{margin-right:1rem !important;}
.mb-3,.my-3{margin-bottom:1rem !important;}
.ml-3,.mx-3{margin-left:1rem !important;}
.m-4{margin:1.5rem !important;}
.mt-4,.my-4{margin-top:1.5rem !important;}
.mr-4,.mx-4{margin-right:1.5rem !important;}
.mb-4,.my-4{margin-bottom:1.5rem !important;}
.ml-4,.mx-4{margin-left:1.5rem !important;}
.m-5{margin:3rem !important;}
.mt-5,.my-5{margin-top:3rem !important;}
.mr-5,.mx-5{margin-right:3rem !important;}
.mb-5,.my-5{margin-bottom:3rem !important;}
.ml-5,.mx-5{margin-left:3rem !important;}
.p-0{padding:0 !important;}
.pt-0,.py-0{padding-top:0 !important;}
.pr-0,.px-0{padding-right:0 !important;}
.pb-0,.py-0{padding-bottom:0 !important;}
.pl-0,.px-0{padding-left:0 !important;}
.p-1{padding:0.25rem !important;}
.pt-1,.py-1{padding-top:0.25rem !important;}
.pr-1,.px-1{padding-right:0.25rem !important;}
.pb-1,.py-1{padding-bottom:0.25rem !important;}
.pl-1,.px-1{padding-left:0.25rem !important;}
.p-2{padding:0.5rem !important;}
.pt-2,.py-2{padding-top:0.5rem !important;}
.pr-2,.px-2{padding-right:0.5rem !important;}
.pb-2,.py-2{padding-bottom:0.5rem !important;}
.pl-2,.px-2{padding-left:0.5rem !important;}
.p-3{padding:1rem !important;}
.pt-3,.py-3{padding-top:1rem !important;}
.pr-3,.px-3{padding-right:1rem !important;}
.pb-3,.py-3{padding-bottom:1rem !important;}
.pl-3,.px-3{padding-left:1rem !important;}
.p-4{padding:1.5rem !important;}
.pt-4,.py-4{padding-top:1.5rem !important;}
.pr-4, px-4{padding-right:1.5rem !important;}
.pb-4,.py-4{padding-bottom:1.5rem !important;}
.pl-4,.px-4{padding-left:1.5rem !important;}
.p-5{padding:3rem !important;}
.pt-5,.py-5{padding-top:3rem !important;}
.pr-5,.px-5{padding-right:3rem !important;}
.pb-5,.py-5{padding-bottom:3rem !important;}
.pl-5,.px-5{padding-left:3rem !important;}
.input-group {display:flex; position:relative; width:100%; align-items:center;}
.btn-outline-secondary {border-color:#ff6866; background-color:transparent; background-image:none; color:#ff6866; border:1px solid #ff6866;}
.btn-outline-secondary:hover {border-color:#ff6866; background-color:#ff6866; color:#fff; }
p{margin-bottom:1rem}
h3{font-size:30px}
.border{border:1px solid #e9ecef !important;}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="container">	
			<div class="row" style="min-height:710px;">
		
			   <div class="col-lg-12" style="margin-top: 30px;">
					<div class="panel panel-info">
						<div class="panel-heading">{{ trans('google2fa.title') }}</div><!-- 2단계 인증 (OTP) -->
						<div class="panel-body text-center">
        <p>{{ trans('messages.google_msg1') }}<!-- 로그인 및 입출금 할 때 OTP앱으로 2단계 인증합니다. --></p>
        <p class="text-primary">{{ trans('messages.google_msg2') }}<!-- 입출금시 휴대폰 인증 번호 대신 OTP 인증번호를 사용하게 됩니다. --></p>
        <div class="h3"><span class="text-muted mr-3">{{ trans('messages.google_msg3') }}<!-- 1단계. --></span><span class="text-primary">{{ trans('messages.google_msg4') }}<!-- OTP앱 다운로드 --></span></div>
        <p>{{ trans('messages.google_msg5') }}<!-- 시간 동기 (Time OTP)방식을 사용하는 OTP 인증 앱을 스마트폰에 다운로드합니다. --></p>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="border py-4 ">
                            <h3>{{ trans('messages.google_msg6') }}<!-- 안드로이드 --></h3>
                            <p>{{ trans('messages.google_msg7') }}<!-- 플레이스토어에서 검색하세요. --></p>
                            <div>
                                <img src="/img/otp_img2.jpg" alt="플레이스토어">
                            </div>
                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko" target="_blank" class="btn btn-success btn-sm">{{ trans('messages.google_msg8') }}<!-- 플레이스토어 OTP --></a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="border py-4 ">
                            <h3>{{ trans('messages.google_msg9') }}<!-- 아이폰 --></h3>
                            <p>{{ trans('messages.google_msg10') }}<!-- 앱스토어에서 검색하세요. --></p>
                            <div>
                                <img src="/img/otp_img.jpg" alt="앱스토어">
                            </div>
                            <a href="https://itunes.apple.com/kr/app/google-authenticator/id388497605?mt=8" target="_blank" class="btn btn-info btn-sm">{{ trans('messages.google_msg11') }}앱스토어 OTP</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-5 col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <img src="/img/googleotp01.jpg" class="img-responsive">
                        <p class="mt-3">{{ trans('messages.google_msg12') }}<!-- Google OTP 앱 신규 사용자 --></p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="/img/googleotp02.jpg" class="img-responsive">
                        <p class="mt-3">{{ trans('messages.google_msg13') }}<!-- Google OTP 앱 기존 사용자 --></p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="h3"><span class="text-muted mr-3">{{ trans('messages.step2') }}<!-- 2단계. --></span><span class="text-primary">{{ trans('messages.qrcodeAuth') }}<!-- QR코드 인증 --></span></div>
        <p>{{ trans('google2fa.enable_text1') }}</p>
        <div class="text-center">
            <img alt="Image of QR barcode" src="{{ $image }}" />
        </div>
        <p>{{ trans('google2fa.enable_text2') }} <code>{{ $secret }}</code></p>
        <hr/>
        <p>{{ trans('google2fa.enable_text3') }}</p>
        <p><code>{{ env('APP_DOMAIN') }} ({{ Auth::user()->name }})</code></p>
        <hr/>
        <form class="form-horizontal text-center" role="form" method="POST" action="{{ url('') }}/2fa/enable">
            {!! csrf_field() !!}
            <!--            <div class="form-group{{ $errors->has('totp') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <label>{{ trans('google2fa.secret') }}</label>
                                <input type="text" class="form-control" maxlength="6" name="totp" placeholder="{{ trans('google2fa.secret_holder') }}">

                                @if ($errors->has('totp'))
                                <span>
                                    <strong>{{ $errors->first('totp') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
            <div class="input-group {{ $errors->has('totp') ? ' has-error' : '' }}">
                <input  type="text" class="form-control" maxlength="6" name="totp" placeholder="{{ trans('google2fa.secret_holder') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit"><span class="glyphicon glyphicon-lock"></span>{{ trans('google2fa.validate') }}</button>
                </div>
            </div>
            @if ($errors->has('totp'))
            <span>
                <strong>{{ $errors->first('totp') }}</strong>
            </span>
            @endif

        </form>
    </div>
						<!-- <div class="panel-body text-center">
						{{ trans('messages.google_msg2') }}
                            {{ trans('google2fa.enable_text1') }}
                            <br />
                            <img alt="Image of QR barcode" src="{{ $image }}" />
                            <br />
                            {{ trans('google2fa.enable_text2') }} <code>{{ $secret }}</code>
                            <br />
                            <br />
                            <hr/>
                            <br />
                            {{ trans('google2fa.enable_text3') }}
                            <br/>
                            <code>{{ env('APP_DOMAIN') }} ({{ Auth::user()->email }})</code>
                            <br />
                            <br />
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('') }}/2fa/enable">
                                {!! csrf_field() !!}

                                <div class="form-group{{ $errors->has('totp') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">{{ trans('google2fa.secret') }}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" maxlength="6" name="totp" placeholder="{{ trans('google2fa.secret_holder') }}">

                                        @if ($errors->has('totp'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('totp') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary" style="width:100%;">
                                            <span class="glyphicon glyphicon-lock"></span> {{ trans('google2fa.validate') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection