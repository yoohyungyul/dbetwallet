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
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        
    </div>
</div>


@endsection


@section('script')
<script>
    

</script>
@endsection
