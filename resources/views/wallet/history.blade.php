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
        <div class="tab-content pt20" >
            <span style="float: right;display: inline-block;padding:0 10px 0 10px">DBET</span>
            <span style="float: right;">100,000,000</span>
       </div>
    </div>
</div>

<hr>
<div class="row mt40">
    <div class="col-12 ">
        <div class="card" >
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script>
    

</script>
@endsection
