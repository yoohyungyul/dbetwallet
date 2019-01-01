@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="row  mt20">
    <div class="col-12">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active" href="#">Wallet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Send</a>
            </li>
        </ul>
    </div>
</div>
<div class="row  mt20">
    <div class="col-12 text-right">
        
        <span style="float: right;display: inline-block;padding:0 10px 0 10px">DBET</span>
        <span style="float: right;">100,000,000</span>
    </div>
</div>
<hr>
<div class="row mt40">
    <div class="col-12 text-center">
        QR CODE Image
    </div>
</div>
<div class="row mt40">
    <div class="col-12 text-center">
        <div class="card" >
            <img src="..." class="card-img-top" alt="QR Code">
            <div class="card-body text-left">
                <h5 class="card-title">Card title</h5>
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
