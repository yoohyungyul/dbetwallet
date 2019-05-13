@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')



<div class="row  mt20">
    <div class="col-12">
        @include('layouts.menu')
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:70px;padding-top:15px;padding-right:10px;">
            <!-- <span style="float: right;display: inline-block;padding:0 10px 0 10px">{{ $currency->label }}</span> -->
            <span style="float: right;">{{ number_format(  $balance->balance, $currency->fixed, ".", ",") }} {{$currency->label}}</span>
            <br>
            <span style="float: right;"><small>{{ number_format( $ethBalance->balance, $currency->fixed, ".", ",") }} ETH</small></span>
       </div>
    </div>

</div>
<div class="row mt20">
    <div class="col-12 ">
        <div class="panel panel-default">
        <div class="panel-body">
            <form action="/buy" name="sendForm" method="POST" onsubmit="return write_btn();">
            {{ csrf_field() }}
            @foreach ($errors->all() as $error)
            <div class="text-center">error : {{ $error }}</div>
            @endforeach
            
            <div class="form-group">
                <label for="amountFormControlInput">ETH Amount</label>
             
                <div class="input-group">
                    <input type="text" class="form-control text-right" id="amountFormControlInput" name="eth_amount" maxlength="26" placeholder="0" autocomplete="off">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" onclick="allBalance();">Total</button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="addressFormControlInput">DBET Amount</label>
                <input type="text" name="dbet_amount" class="form-control  text-right" id="addressFormControlInput" placeholder="0" readonly>
               
            </div>
            <div class="form-group">
                <label for="outFormControlInput">OTP</label>
                <input type="text" name="totp" id="totp" class="form-control input-lg" id="outFormControlInput" placeholder="OTP" maxlength="6">
            </div>
            <button type="submit" id="buy_btn" class="btn btn-primary btn-block">BUY</button>
            </form>
            </div>
           
        </div>
    </div>
</div>



@endsection


@section('script')

<script>

    function write_btn() {
        
        var btn = $('#buy_btn');
        btn.attr('disabled','disabled');
        setTimeout(function() {
        btn.removeAttr('disabled');
        }, 1000);

        if($('#eth_balance').val() < 0.05) {
            alert("There is not enough Etherium coin. ");
            return false;
        }
        
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
        $('#amountFormControlInput').val('{{ $ethBalance->balance }}');
    }
</script>
@endsection
