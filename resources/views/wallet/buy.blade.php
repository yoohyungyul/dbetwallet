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
            <form action="/buy" name="buyForm" method="POST" onsubmit="return write_btn();">
            {{ csrf_field() }}
            <input type="hidden" name="total_eth_amount" value="0"/>

            @if($waitBalance > 0 )
            <div class="text-center" style="margin-bottom:20px;"><small>구매 대기중 수량 : {{ number_format( $waitBalance, $ethCurrency->fixed, ".", ",") }} {{$ethCurrency->label}}</small></div>
            @endif
            
            @foreach ($errors->all() as $error)
            <div class="text-center">error : {{ $error }}</div>
            @endforeach
            
            <div class="form-group">
                <label for="amountFormControlInput">ETH 수량</label>
             
                <div class="input-group">
                    <input type="text" class="form-control text-right" id="amountFormControlInput" name="eth_amount" maxlength="26" placeholder="0" autocomplete="off">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" onclick="allBalance();">Total</button>
                    </span>
                </div>
                <p class="text-right"><small>예상 결제 수량(수수료 {{ number_format( $ethCurrency->fee, 4, ".", ",") }} {{$ethCurrency->label}} 포함): <span id="total_eth_amount">0</span> ETH </small></p>
            </div>
            <div class="form-group">
                <label for="addressFormControlInput">DBET 수량</label>
                <input type="text" name="dbet_amount" class="form-control  text-right" id="addressFormControlInput" placeholder="0" readonly>
               
            </div>
            <div class="form-group">
                <label for="outFormControlInput">OTP</label>
                <input type="text" name="totp" id="totp" class="form-control input-lg" id="outFormControlInput" placeholder="OTP" maxlength="6">
            </div>
            <button type="submit" id="buy_btn" class="btn btn-primary btn-block">구매하기</button>
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
            exchange();
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


        var total_eth_amount = $("input[name='total_eth_amount']").val();
        var limit_min = parseFloat("{{$ethCurrency->limit_min}}");
        var ethBalance = parseFloat("{{$ethBalance}}");
        var waitBalance = parseFloat("{{$waitBalance}}");

        // alert(ethBalance);

        if(total_eth_amount < limit_min) {
            alert("최소 구매 수량은 "+limit_min+"개입니다. ");
            return false;
        }

        if(total_eth_amount > (ethBalance - waitBalance) ) {
            alert("결제 수량이 부족합니다. ");
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

        var ethBalance = parseFloat("{{ $ethBalance }}");
        var fee = parseFloat("{{$ethCurrency->fee}}");
        var waitBalance = parseFloat("{{$waitBalance}}");
        var limit_min = parseFloat("{{$ethCurrency->limit_min}}");
        var all = ethBalance - waitBalance - fee;
        
        if(all > limit_min ) {

            $('#amountFormControlInput').val( Number(all.toFixed(8)) )    ;
            exchange();
        } else {
            alert("수량이 부족합니다. ");
        }
    }

    function exchange() {


         var eth_amount = $("input[name='eth_amount']").val();

        if(eth_amount) {
            if(!isNumber(eth_amount) ) {
                bootbox.alert('숫자만 입력해 주세요. ');
                $('#total_eth_amount').html('0');
                $("input[name='eth_amount']").val('0');
                $("input[name='total_eth_amount']").val('0');
                $("input[name='dbet_amount']").val('0');
                $("input[name='eth_amount']").focus();
                
                return false;
            }

            var eth_target = parseFloat("{{$ethCurrency->target}}");
            var dbet_target = parseFloat("{{$currency->target}}");
            var fee = parseFloat("{{$ethCurrency->fee}}");

            var total_eth_amount = parseFloat(eth_amount) + fee ;
            var dbet_amount = (parseFloat(eth_amount) * eth_target) / dbet_target;
        } else {
            var total_eth_amount = 0;
            var dbet_amount = 0;
        }   

         $("input[name='total_eth_amount']").val(total_eth_amount);
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
