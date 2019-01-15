@extends('layouts.master')

@section('content')


		<div class="container">	
			<div class="row" style="min-height:710px;">
			   <div class="col-lg-12" style="margin-top: 30px;">
					<div class="panel panel-info">
						<div class="panel-body text-center" style="margin-bottom:30px">
                            <div class="h3"><span class="text-muted mr-3">1단계.</span><span class="text-primary">OTP앱 다운로드</span></div>
                            <p>시간 동기 (Time OTP)방식을 사용하는 OTP 인증 앱을 스마트폰에 다운로드합니다.</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <div class="border py-4 ">
                                                <h3>안드로이드</h3>
                                                <p>플레이스토어에서 검색하세요.</p>
                                                <div>
                                                    <img src="/img/otp_img2.jpg" alt="플레이스토어">
                                                </div>
                                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko" target="_blank" class="btn btn-success btn-sm">플레이스토어 OTP</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <div class="border py-4 ">
                                                <h3>아이폰</h3>
                                                <p>앱스토어에서 검색하세요.</p>
                                                <div>
                                                    <img src="/img/otp_img.jpg" alt="앱스토어">
                                                </div>
                                                <a href="https://itunes.apple.com/kr/app/google-authenticator/id388497605?mt=8" target="_blank" class="btn btn-info btn-sm">앱스토어 OTP</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-5 col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <img src="/img/googleotp01.jpg" class="img-responsive">
                                            <p class="mt-3">Google OTP 앱 신규 사용자</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <img src="/img/googleotp02.jpg" class="img-responsive">
                                            <p class="mt-3">Google OTP 앱 기존 사용자</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="h3"><span class="text-muted mr-3">2단계.</span><span class="text-primary">QR코드 인증</span></div>
                            <p>Launch the 2-step verification mobile app and scan the QR code below:</p>
                            <div class="text-center">
                                <img alt="Image of QR barcode" src="{{ $image }}" />
                            </div>
                            <p>If your mobile app does not support QR code, please enter this code manually: <code>{{ $secret }}</code></p>
                            <hr/>
                            <p>Enter the code displayed on the OTP after scanning the QR code.</p>
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
                                    <input  type="text" class="form-control" maxlength="6" name="totp" placeholder="Please enter OTP code">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><span class="glyphicon glyphicon-lock"></span>certification</button>
                                    </div>
                                </div>
                                @if ($errors->has('totp'))
                                <span>
                                    <strong>{{ $errors->first('totp') }}</strong>
                                </span>
                                @endif

                            </form>
                            <hr/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection