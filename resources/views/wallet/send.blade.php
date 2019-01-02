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
                <a class="nav-item nav-link " href="/history" >History</a>
                <a class="nav-item nav-link active"   href="/send" >Send</a>
            </div>
        </nav>
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:50px;padding-top:15px;">
            <span style="float: right;display: inline-block;padding:0 10px 0 10px">DBET</span>
            <span style="float: right;">100,000,000</span>
       </div>
    </div>
</div>
<div class="row mt20">
    <div class="col-12 ">
        <div class="panel panel-default">
            <div class="panel-body">
                <form>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Wallet Address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Wallet Address">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Amount</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Amount">
                </div>
                <button type="submit" class="btn btn-primary btn-block">SEND</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script>
    

</script>
@endsection
