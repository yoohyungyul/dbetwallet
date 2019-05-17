@extends('layouts.master')

@section('content')


		<div class="container">	
			<div class="row" style="min-height:710px;">
			   <div class="col-lg-12" style="margin-top: 30px;">
					<div class="panel panel-info">
						<div class="panel-body text-center" style="margin-bottom:30px">
                            <div class="h3"><span class="text-muted mr-3">1단계 .</span><span class="text-primary">OTP 앱 다운로드</span></div>
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
                                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko" target="_blank" class="btn btn-success btn-sm">플레이스토어 OT</a>
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
                                            <img src="/img/googleotp01.jpg" class="img-responsive" style="width:100%">
                                            <p class="mt-3">Google OTP 앱  신규 사용자</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <img src="/img/googleotp02.jpg" class="img-responsive" style="width:100%">
                                            <p class="mt-3">Google OTP 앱 기존 사용자</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="h3"><span class="text-muted mr-3">Step 2.</span><span class="text-primary">OTP 코드 인증</span></div>
                            <p>2단계. 인증 모바일 앱을 실행하여 아래의 QR코드를 스캔하세요:</p>
                            <div class="text-center">
                                <img alt="Image of QR barcode" src="{{ $image }}" />
                            </div>
                            <p>만약 모바일 앱이 QR코드를 지원하지 않는다면, 이 코드를 직접 입력하세요: <code>{{ $secret }}</code></p>
                            <hr/>
                            <p>QR코드 스캔 후 OTP에 표시되는 코드를 입력하세요.</p>
                            <p><code>{{ env('APP_DOMAIN') }} ({{ Auth::user()->email }})</code></p>
                            <hr/>
                            @foreach ($errors->all() as $error)
                            <div class="text-center">error : {{ $error }}</div>
                            @endforeach
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
                                        <button class="btn btn-outline-secondary" type="submit"><span class="glyphicon glyphicon-lock"></span>인증</button>
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