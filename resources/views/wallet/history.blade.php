@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="row  mt20">
    <div class="col-12">
       <nav>
            <div class="nav nav-tabs nav-fill" >
                <a class="nav-item nav-link "  href="/wallet" >Wallet</a>
                <a class="nav-item nav-link active" href="/history" >History</a>
                <a class="nav-item nav-link "   href="/send" >Send</a>
            </div>
        </nav>
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:50px;padding-top:15px;padding-right:10px;">
            <!-- <span style="float: right;display: inline-block;padding:0 10px 0 10px">{{ $currency->label }}</span> -->
            <span style="float: right;">{{ number_format(  $balance->balance, $currency->fixed, ".", ",") }}{{ $currency->unit }}</span>
       </div>
    </div>
</div>
<div class="row mt20">
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
                        <td>{{ $item->created_at }}</td>
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
                        <td>{{ number_format(  $item->amount, $currency->fixed, ".", ",") }}{{ $currency->unit }}</td>
                        <td>{{ number_format(  $item->balance, $currency->fixed, ".", ",") }}{{ $currency->unit }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
       
    </div>
    @if($list)
    <div class="col-12">
        {!! $list->render() !!} 
    </div>
    @endif
</div>



@endsection


@section('script')
<script>
    

</script>
@endsection
