@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="row  mt20">
    <div class="col-12">
       <nav>
            <div class="nav nav-tabs nav-fill" >
                <a class="nav-item nav-link active"  href="/wallet" >Wallet</a>
                <a class="nav-item nav-link" href="/history" >History</a>
                <a class="nav-item nav-link"   href="/send" >Send</a>
            </div>
        </nav>
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:50px;padding-top:15px;">
            <span style="float: right;display: inline-block;padding:0 10px 0 10px">DBET</span>
            <span style="float: right;">{{ number_format(  $balance->balance, $currency->fixed, ".", ",") }}{{ $currency->unit }}</span>
       </div>
    </div>
</div>
<div class="row mt20">
    <div class="col-12 text-center">
        <div class="card text-center" style="display: block">
            <div style="padding:20px 0px">
                <div id="deposit_qrcode"></div>
            </div>
            <div class="card-body text-left">
                <span style="float: right;"  id="clipboard2"  data-clipboard-target="#wallet_address"><i class="far fa-copy" ></i></span>
                <h5 class="card-title">Address
                    
                </h5>
                <p class="card-text" id="wallet_address">{{ $wallet->address}}</p>
                
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script src="/js/jquery.qrcode-0.12.0.min.js"></script>
<script src="/clipboard/dist/clipboard.min.js"></script>
<script>
    
var clipboard = new Clipboard('#clipboard2');

clipboard.on('success', function(e) {
    $('#wallet_address').blur();
    alert('cliped');
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
