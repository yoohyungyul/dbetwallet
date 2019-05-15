@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" >
                <div class="panel-body mt70" >
                    <form  role="form" method="POST" action="{{ url('/register') }}"  autocomplet="off" onsubmit="return write_btn(this);">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">이름</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recommender" class="col-md-4 control-label">추천인 코드</label>

                            <div class="col-md-6">
                                <input id="recommender" type="text" class="form-control" name="recommender" value="">
                               
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Captcha</label>

                            <div class="col-md-12">
                                <div class="captcha">
                                    <span>{!! captcha_img() !!}</span>
                                    <button class="btn btn-success btn-refresh">새로고침</button>
                                    <input type="text" id="captcha" name="captcha" class="form-control mt10" placeholder="Enter Captcha" maxlength="5"/>
                                    @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>

                        


                        
                        <hr>

                        

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> 가입하기
                                </button>
                            </div>
                            <div class="col-md-12 text-right">
                                <a href="/2fa/login">OTP 로그인</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    function write_btn(f) {
        if(f.name.value == "") {
            alert("이름을 입력하세요.");
            return false;
        }

        if(f.email.value == "") {
            alert("E-Mail을 입력하세요.");
            return false;
        }
        if(f.captcha.value == "") {
            alert("Captcha를 입력하세요.");
            return false;
        }

        return true;
       


    }

</script>
@endsection