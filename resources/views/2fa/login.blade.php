@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-body mt70">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/2fa/login') }}">
                        {{ csrf_field() }}

                        @foreach ($errors->all() as $error)
                        <div class="text-center">error : {{ $error }}</div>
                        @endforeach

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-4 control-label">E-Mail</label>

                            <div class="col-12">
                                <input id="email" type="email" class="form-control" name="email">

                               
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-4 control-label">OTP CODE</label>

                            <div class="col-12">
                                <input id="totp" type="text" class="form-control" name="totp" value="" maxlength="6">

                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> 로그인
                                </button>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/register" class="btn btn-light">가입하기</a>
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
    

</script>
@endsection