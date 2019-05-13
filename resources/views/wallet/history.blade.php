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
{!! Form::open(array('url' => URL::to('/history'), 'method' => 'get','name'=>'searchForm','id'=>'searchForm')) !!}

{!! Form::hidden('currency_id',$currency_id) !!}
    <div class="col-12">
        <div class="custom-control custom-radio" style="float:left;width:90px">
            <input type="radio" name="currency" id="currency-1" value="2" class="custom-control-input currency" @if($currency_id == "2")checked="checked"@endif>
            <label class="custom-control-label" for="currency-1">DBET</label>
        </div>
        <div class="custom-control custom-radio" style="float:left;width:70px">
            <input type="radio" name="currency" id="currency-2" value="3" class="custom-control-input currency" @if($currency_id == "3")checked="checked"@endif>
            <label class="custom-control-label" for="currency-2">ETH</label>
        </div>
    </div>
</div>
{!! Form::close() !!}

<div class="row mt10">
    <div class="col-12 ">
        <div style="width:100%; overflow:auto">

            <table class="table table-hover" style="word-wrap: break-word; width='100%'">
                <thead>
                    <tr>
                    <th scope="col" width="30%">DATE</th>
                    <th scope="col" width="30%">ADDRESS</th>
                    <th scope="col" width="20%">AMOUNT</th>
                    <th scope="col" width="20%">BALANCE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                    <tr>
                        <td style="line-height: 20px;">{{ substr($item->created_at,0,10)  }}<br><small>{{ substr($item->created_at,11)  }}</small></td>
                        <td>
                            @if($item->type == "1")
                                Send to<br>
                                {{$item->address_to}}
                            @else
                                Received at<br>
                                {{$item->address_from}}
                            @endif

                            @if($item->state == "0")
                                <span class="btn btn-secondary btn-sm">pending</span>
                                
                            @else
                                <span class="btn btn-success btn-sm">confirmed</span>
                                <br>
                                <a href="https://etherscan.io/tx/{{$item->txid}}" target="_blank">View transaction details</a>
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
