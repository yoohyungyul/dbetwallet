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
    <div class="col-12 ">
        <div style="width:100%; overflow:auto">
            <ul class="list-group">
            @foreach ($list as $item)
            <li class="list-group-item">
                
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-7">
                        <small>{{ $item->created_at  }}</small>
                    </div>
                    <div class="col-5 text-right">
                        @if($item->state == "0")
                            <span class="btn btn-secondary" style="font-size: 12px;padding: 1px 5px;">진행중</span>
                            
                        @else
                            <span class="btn btn-success" style="font-size: 12px;padding: 1px 5px;">거래완료</span>
                            <!-- <br>
                            <a href="https://etherscan.io/tx/{{$item->txid}}" target="_blank">상세보기</a> -->
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                    @if($item->type == "1")
                        보낸 코인
                    @else
                        받은 코인
                    @endif
                    </div>
                    <div class="col-8 text-right">
                    {{ number_format( $item->amount, $currency->fixed, ".", ",") }} {{$currency->unit}}
                    </div>
                </div>

                @if($item->type == "1")
               
                <p style="margin:0px;"><small>{{$item->address_to}}</small></p>
                @else
                <p style="margin:0px;"><small>{{$item->address_from}}</small></p>
                @endif

            </li>
            @endforeach
            </ul>
        </div>

        
       
    </div>
    
</div>

<div class="row mt20 mb20">
    <div class="col-12 text-center">
        {!! $list->render() !!} 
    </div>
</div>


@endsection


@section('script')
<script>
    
    $(".currency").change(function () {
        $("#searchForm").submit();
    });
</script>
@endsection
