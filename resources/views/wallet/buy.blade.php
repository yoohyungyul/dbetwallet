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
                <p class="text-right"><small>예상 결제 수량: <span id="total_eth_amount">0</span> ETH </small></p>
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
    $( document ).ready( function() {
        $("input[name='eth_amount']").keyup(function () {
         
            var eth_amount = $("input[name='eth_amount']").val();

            if(eth_amount) {
                exchange();
            }
            

        });
    });

    function write_btn() {

        // if( !fee1 ){
        //         bootbox.alert('수수료를 입력해 주세요. ');
        //         $("input[name='level1_fee']").focus();
        //         return false;
        //     }
        
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
        exchange();
    }

    function exchange() {

        var eth_amount = $("input[name='eth_amount']").val();
        if(!isNumber(eth_amount) ) {
            bootbox.alert('숫자만 입력해 주세요. ');
            $("input[name='eth_amount']").val('');
            $('#total_eth_amount').html('0');
            $("input[name='eth_amount']").focus();
            return false;
        }

        var total_eth_amount = parseFloat(eth_amount) + 0.0001;
        var dbet_amount = (parseFloat(eth_amount) * 200000) / 50;
        

        $('#total_eth_amount').html(  Number(total_eth_amount.toFixed(8))   );
        $("input[name='dbet_amount']").val(  Number(dbet_amount.toFixed(8))   );
    }

    function isNumber(s) {
        s += ''; // 문자열로 변환
        s = s.replace(/^\s*|\s*$/g, ''); // 좌우 공백 제거
        if (s == '' || isNaN(s)) return false;
        return true;
    }
</script>
@endsection
