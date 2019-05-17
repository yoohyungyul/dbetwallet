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
        <div style="width:100%; overflow:auto">
            <ul class="list-group">
            @foreach ($list as $item)
            <li class="list-group-item">
                <p style="margin:0px;"><small>{{ $item->created_at  }}</small></p>

                @if($item->type == "1")
                <p style="margin:0px;">보낸 주소</p>
                <p style="margin:0px;">{{$item->address_to}}</p>
                @else
                <p style="margin:0px;">받은 주소</p>
                <p style="margin:0px;"><small>{{$item->address_from}}</small></p>
                @endif

            </li>
            @endforeach
            </ul>
        </div>

        <div style="width:100%; overflow:auto">
            

            <table class="table table-hover" style="word-wrap: break-word; width='100%'">
                <thead>
                    <tr>
                    <th scope="col" width="30%">거래일시</th>
                    <th scope="col" width="30%">지갑주소</th>
                    <th scope="col" width="20%">수량</th>
                    <th scope="col" width="20%">남은수량</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                    <tr>
                        <td style="line-height: 20px;">{{ substr($item->created_at,0,10)  }}<br><small>{{ substr($item->created_at,11)  }}</small></td>
                        <td>
                            @if($item->type == "1")
                                보낸 주소<br>
                                {{$item->address_to}}
                            @else
                                받은 주소<br>
                                {{$item->address_from}}
                            @endif

                            @if($item->state == "0")
                                <span class="btn btn-secondary btn-sm">진행중</span>
                                
                            @else
                                <span class="btn btn-success btn-sm">거래완료</span>
                                <br>
                                <a href="https://etherscan.io/tx/{{$item->txid}}" target="_blank">상세보기</a>
                            @endif
                            

                        </td>
                        <td>{{ number_format(  $item->amount, $currency->fixed, ".", ",") }}</td>
                        <td>{{ number_format(  $item->balance, $currency->fixed, ".", ",") }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
