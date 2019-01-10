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
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:50px;padding-top:15px;">
            <span style="float: right;display: inline-block;padding:0 10px 0 10px">{{ $currency->label }}</span>
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
                <div class="form-group">
                    <label for="addressFormControlInput">Wallet Address</label>
                    <input type="text" name="address" id="address" class="form-control input-lg" id="addressFormControlInput" placeholder="Wallet Address">
                </div>
                <div class="form-group">
                    <label for="amountFormControlInput">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control input-lg" id="amountFormControlInput" placeholder="0">
                </div>
                <div class="form-group">
                    <label for="amountFormControlInput">OTP</label>
                    <input type="text" name="totp" id="totp" class="form-control input-lg" id="amountFormControlInput" placeholder="Amount">
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
            $('#address').val('');
            alert("address. ");
            return false;
        }
        
    
        if($('#amount').val() == '') {
            $('#amount').val('');
            alert("amount. ");
            return false;
        }

        if($('#amount').val() == '0') {
            $('#amount').val('');
            alert("amount. ");
            return false;
        }


        if($('#totp').val() == '') {
            $('#totp').val('');
            alert("totp. ");
            return false;
        }

        return true;
    }
</script>
@endsection
