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
        <div class="tab-content " style="background:#fff;display: inline-block;width:100%;height:50px;padding-top:15px;">
            <span style="float: right;display: inline-block;padding:0 10px 0 10px">DBET</span>
            <span style="float: right;">100,000,000</span>
       </div>
    </div>
</div>
<div class="row mt20">
    <div class="col-12 ">

        <ul class="list-group list-group-flush">
            <li class="list-group-item">0xaaed4eb400d7ab2f237bf9c3eda2e3e8173f0c6a</li>
            <li class="list-group-item">Dapibus ac facilisis in</li>
            <li class="list-group-item">Morbi leo risus</li>
            <li class="list-group-item">Porta ac consectetur ac</li>
            <li class="list-group-item">Vestibulum at eros</li>
        </ul>
        
    </div>
    <div class="col-12">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>
        </nav>
    </div>
</div>



@endsection


@section('script')
<script>
    

</script>
@endsection
