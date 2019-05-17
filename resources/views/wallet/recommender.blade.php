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
            
            총 추천 수 : {{number_format(count($recoms))}}</span>
        </div>
       
        <div class="row">
            <div class="col-3">ETH</div>
            <div class="col-9 text-right">{{ number_format( $eth_total, 8, ".", ",") }} e</div>
        </div>
        <div class="row" style="margin-bottom:10px">
            <div class="col-3">DBET</div>
            <div class="col-9 text-right">{{ number_format( $dbet_total, 8, ".", ",") }} e</div>
        </div>

        @foreach($recoms as $item)
        <div class="card text-center" style="display: block;margin-bottom:10px">
          
            <div class="card-body text-left">
                <div class="row" style="margin-bottom:10px">
                    <div class="col-7">{{$item->user->name}}</div>
                    <div class="col-5 text-right"><small>{{substr($item->user->created_at,0,10)}}</small></div>
                </div>
                
                @foreach($item->coin as $coin)
                <div class="row">
                    <div class="col-3">{{$coin->label}}</div>
                    <div class="col-9 text-right">{{ number_format( $coin->balance, $coin->fixed, ".", ",") }} {{$coin->unit}}</div>
                </div>
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
