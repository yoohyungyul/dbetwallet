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
        <div class="tab-content pt20" >
            <span style="float: right;display: inline-block;padding:0 10px 0 10px">DBET</span>
            <span style="float: right;">100,000,000</span>
       </div>
    </div>
</div>

<hr>
<div class="row mt40">
    <div class="col-12 text-center">
        <div class="card text-center" >
            <img src="/img/qrcode.png" class="card-img-top pt20" alt="QR Code">
            <div class="card-body text-left">
                <span style="float: right;">복사</span>
                <h5 class="card-title">Address
                    
                </h5>
                <p class="card-text">0x234ljdsf330fsdjlfkjl3jildijfi3il2j3i4kdjfij3</p>
                
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script>
    

</script>
@endsection
