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
            <span style="float: right;"><small>{{ number_format( $ethBalance, $currency->fixed, ".", ",") }} ETH</small></span>
       </div>
    </div>

</div>
<div class="row mt20">
    <div class="col-12 ">
        <div>
            총 추천 수 : {{count($recoms)}}
        </div>

        @foreach($recoms as $item)
        <div class="card text-center" style="display: block;margin-bottom:10px">
          
            <div class="card-body text-left">
                <p>{{$item->user->name}}</p>
                @foreach($item->coin as $coin)
                <p>{{$coin->label}} : {{ number_format( $coin->balance, $coin->fixed, ".", ",") }} {{$coin->unit}}</p>
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
