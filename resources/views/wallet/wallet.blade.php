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
            <span style="float: right;">{{ number_format(  $dbetBalance, $currency->fixed, ".", ",") }} {{$currency->label}}</span><br>
            <span style="float: right;"><small>{{ number_format( $ethBalance, $ethCurrency->fixed, ".", ",") }} {{$ethCurrency->label}}</small></span>
       </div>
    </div>
</div>
<div class="row mt20">
    <div class="col-12 text-center">
        <div class="card text-center" style="display: block">
            <div style="padding:30px 0px">
                <div id="deposit_qrcode"></div>
            </div>
            <div class="card-body text-left">
                <span style="float: right;"  id="clipboard1"  data-clipboard-target="#wallet_address"><i class="far fa-copy" ></i></span>
                <h5 class="card-title">지갑 주소
                    
                </h5>
                <p class="card-text" id="wallet_address">{{ $wallet->address}}</p>
                
            </div>
        </div>
    </div>
</div>
<div class="row mt20 mb20">
    <div class="col-12 text-center">
        <div class="card text-center" style="display: block">
            
            <div class="card-body text-left">
                <span style="float: right;"  id="clipboard2"  data-clipboard-target="#recommender_code"><i class="far fa-copy" ></i></span>
                <h5 class="card-title">추천 코드
                    
                </h5>
                <p class="card-text" id="recommender_code">{{ Auth::user()->recommender_code }}</p>
                <p><a class="btn btn-primary btn-block" href="/recommender" >추천인 보기</a></p>
                
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script src="/js/jquery.qrcode-0.12.0.min.js"></script>
<script src="/clipboard/dist/clipboard.min.js"></script>
<script>
    
var clipboard1 = new Clipboard('#clipboard1');

clipboard1.on('success', function(e) {
    $('#wallet_address').blur();
    alert('복사 되었습니다.');
});

var clipboard2 = new Clipboard('#clipboard2');

clipboard2.on('success', function(e) {
    $('#recommender_code').blur();
    alert('복사 되었습니다.');
});

make_qrcode();

function make_qrcode() {
    if($('#wallet_address').html() != '0') {
        $('#deposit_qrcode').html('');
        $('#deposit_qrcode').qrcode({
            'size' : 250,
            'text' : $('#wallet_address').html(),
            'render' : 'image',
        });
    } 
}


</script>
@endsection
