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

              
            </div>
           
        </div>
    </div>
</div>



@endsection


@section('script')

<script>
    
</script>
@endsection
