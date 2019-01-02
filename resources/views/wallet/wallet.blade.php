@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="row  mt20">
    <div class="col-12">
        <!-- <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active" href="#">Wallet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Send</a>
            </li>
        </ul> -->
        <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
        </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
        </div>
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
        <div class="card" >
            <img src="..." class="card-img-top" alt="QR Code">
            <div class="card-body text-left">
                <h5 class="card-title">Address
                    <span class="pull-right">1</span>
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
