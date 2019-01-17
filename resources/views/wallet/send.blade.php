@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')


{!! session()->get('error') !!}
<div class="row  mt20">
    <div class="col-12">
       <nav>
            <div class="nav nav-tabs nav-fill" >
                <a class="nav-item nav-link "  href="/wallet" >Wallet</a>
                <a class="nav-item nav-link " href="/history" >History</a>
                <a class="nav-item nav-link active"   href="/send" >Send</a>
            </div>
        </nav>
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:50px;padding-top:15px;padding-right:10px;">
            <!-- <span style="float: right;display: inline-block;padding:0 10px 0 10px">{{ $currency->label }}</span> -->
            <span style="float: right;">{{ number_format(  $balance->balance, $currency->fixed, ".", ",") }}{{ $currency->unit }}</span>
       </div>
    </div>

    {{ URL::asset('/qr_login/jsqrcode-combined.min.js') }}
</div>
<div class="row mt20">
    <div class="col-12 ">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="/send" method="POST" onsubmit="return write_btn();">
                {{ csrf_field() }}
                @foreach ($errors->all() as $error)
                <div class="text-center">error : {{ $error }}</div>
                @endforeach
                <div class="form-group">
                    <label for="addressFormControlInput">Wallet Address</label>
                    <input type="text" name="address" id="address" class="form-control input-lg" id="addressFormControlInput" placeholder="Wallet Address">
                </div>
                <div class="form-group">
                    <label for="amountFormControlInput">Amount</label>
                    <!-- <input type="text" name="amount" id="amount" class="form-control input-lg" id="amountFormControlInput" placeholder="0"> -->

                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="amountFormControlInput" name="amount" maxlength="26" placeholder="0" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="allBalance();">Total</button>
                        </span>
                    </div>



                </div>
                <div class="form-group">
                    <label for="outFormControlInput">OTP</label>
                    <input type="text" name="totp" id="totp" class="form-control input-lg" id="outFormControlInput" placeholder="OTP" maxlength="6">
                </div>
                <button type="submit" id="withdrawal_btn" class="btn btn-primary btn-block">SEND</button>
                </form>


                


                <!--input type=text size=16 placeholder="Tracking Code" class=qrcode-text><label class=qrcode-text-btn><input type=file accept="image/*" capture=environment onchange="openQRCamera(this);" tabindex=-1></label> 
                <input type=button value="Go" disabled>

                <style>
                body, input {font-size:14pt}
                input, label {vertical-align:middle}
                .qrcode-text {padding-right:1.7em; margin-right:0}
                .qrcode-text-btn {display:inline-block; background:url(//dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg) 50% 50% no-repeat; height:1em; width:1.7em; margin-left:-1.7em; cursor:pointer}
                .qrcode-text-btn > input[type=file] {position:absolute; overflow:hidden; width:1px; height:1px; opacity:0}
                </style-->


            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script>
    
    function write_btn() {
	
        var btn = $('#withdrawal_btn');
        btn.attr('disabled','disabled');
        setTimeout(function() {
        btn.removeAttr('disabled');
        }, 1000);


        if($('#address').val() == '') {
            $('#address').focus();
            alert("Please enter your address. ");
            return false;
        }
        
    
        if($('#amount').val() == '') {
            $('#amount').focus();
            alert("Please enter your amount. ");
            return false;
        }

        if($('#amount').val() == '0') {
            $('#amount').focus();
            alert("Please enter your amount. ");
            return false;
        }


        if($('#totp').val() == '') {
            $('#totp').focus();
            alert("Please enter your otp. ");
            return false;
        }

        return true;
    }
    
    function allBalance() {
        $('#amountFormControlInput').val('{{ $balance->balance }}');
    }
</script>
@endsection
