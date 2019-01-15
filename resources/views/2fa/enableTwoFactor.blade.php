@extends('layouts.master')

@section('content')

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