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
        <div class="text-right">
            
            총 추천 수 : {{count($recoms)}}</span>
        </div>
        <div>
            <p>ETH 총 :  {{ number_format( $eth_total, 8, ".", ",") }} e</p>
            <p>DBET 총 :  {{ number_format( $dbet_total, 8, ".", ",") }} d</p>
        </div>

        @foreach($recoms as $item)
        <div class="card text-center" style="display: block;margin-bottom:10px">
          
            <div class="card-body text-left">
                <div class="row">
                    <div class="col-7">{$item->user->name}}</div>
                    <div class="col-7"><small>{$item->user->created_at}}</small></div>
                </div>
                
                @foreach($item->coin as $coin)
                <p style="margin:0px">{{$coin->label}} : {{ number_format( $coin->balance, $coin->fixed, ".", ",") }} {{$coin->unit}}</p>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>
</div>



@endsection


@section('script')

<script>
    


</script>
@endsection
