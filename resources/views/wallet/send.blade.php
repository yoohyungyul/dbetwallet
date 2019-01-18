@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')



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
                    
                    <div class="input-group">
                    <input type="text" name="address" id="address" class="form-control input-lg" id="addressFormControlInput" placeholder="Wallet Address">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="fnQrCode();">Scan</button>
                        </span>
                    </div>

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

    function fnQrCode() {
        alert("ddd");
    }


</script>
@endsection
