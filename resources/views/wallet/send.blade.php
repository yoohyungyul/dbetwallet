@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')



<div class="row  mt20">
    <div class="col-12">
        @include('layouts.menu')
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:70px;padding-top:15px;padding-right:10px;">
            <span style="float: right;">{{ number_format(  $dbetBalance, $currency->fixed, ".", ",") }} {{$currency->label}}</span><br>
            <span style="float: right;"><small>{{ number_format( $ethBalance, $ethCurrency->fixed, ".", ",") }} {{$ethCurrency->label}}</small></span>
       </div>
    </div>

</div>
<div class="row mt20">
    <div class="col-12 ">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="/send" name="sendForm" method="POST" onsubmit="return write_btn();">
                {{ csrf_field() }}
                <input type="hidden" id="eth_balance" name="eth_balance" value="{{$ethBalance}}" />
                @foreach ($errors->all() as $error)
                <div class="text-center">error : {{ $error }}</div>
                @endforeach
                <div class="form-group">
                    <label for="addressFormControlInput">DBET 지갑주소</label>
                    <input type="text" name="address" id="address" class="form-control input-lg" id="addressFormControlInput" placeholder="Wallet Address">
                   
                </div>
                <div class="form-group">
                    <label for="amountFormControlInput">DBET 수량</label>
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="amountFormControlInput" name="amount" maxlength="26" placeholder="0" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="allBalance();">Total</button>
                        </span>
                    </div>
                    <p ><small>최소 ETH 수량 : {{ number_format( $ethCurrency->fee, $ethCurrency->fixed, ".", ",") }} (거래 수수료)</small></p>
                </div>
                <div class="form-group">
                    <label for="outFormControlInput">OTP</label>
                    <input type="text" name="totp" id="totp" class="form-control input-lg" id="outFormControlInput" placeholder="OTP" maxlength="6">
                </div>
                <button type="submit" id="withdrawal_btn" class="btn btn-primary btn-block">보내기</button>
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

        if($('#eth_balance').val() < 0.05) {
            alert("이더리움이 부족합니다. ");
            return false;
        }
        
        if($('#address').val() == '') {
            $('#address').focus();
            alert("지갑주소를 입력해 주세요 ");
            return false;
        }
        
    
        if($('#amount').val() == '') {
            $('#amount').focus();
            alert("수량을 입력해주세요. ");
            return false;
        }

        if($('#amount').val() == '0') {
            $('#amount').focus();
            alert("수량을 입력해주세요. ");
            return false;
        }


        if($('#totp').val() == '') {
            $('#totp').focus();
            alert("OTP를 입력해 주세요. ");
            return false;
        }

        return true;
    }
    
    function allBalance() {
        $('#amountFormControlInput').val('{{ $dbetBalance }}');
    }

    function fnQrCode() {

         // window.name = "부모창 이름"; 
        window.name = "sendForm";
            // window.open("open할 window", "자식창 이름", "팝업창 옵션");
        openWin = window.open("/instascan","qrForm", "resizable = no, scrollbars = no");    
        


    }


</script>
@endsection
