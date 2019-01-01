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
    <div class="col-8 text-right">
        <span>100,000,000</span>
    </div>
    <div class="col-4">
        DBET
    </div>

</div>


@endsection


@section('script')
<script>
    

</script>
@endsection
