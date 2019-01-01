@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="row  mt20">
    <div class="col-12">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active" href="#">Wallet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Send</a>
            </li>
        </ul>
    </div>
</div>
<div class="row  mt20">
    <div class="col-12 text-right">
        <span style="float: right;">100,000,000</span>
        <span style="float: right;display: inline-block;background:#ff00ff">DBET</span>
    </div>
</div>


@endsection


@section('script')
<script>
    

</script>
@endsection
