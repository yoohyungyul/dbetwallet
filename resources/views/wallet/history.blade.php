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

        <div class="panel with-nav-tabs panel-default safetab">
            
            <div class="panel-body">
                <table class="table  table-hover" >
                    <thead >
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Txid</th>
                        <th scope="col">수량</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>0xaaed4eb400d7ab2f237bf9c3eda2e3e8173f0c6a</td>
                        <td>1.000000</td>
                        <td><button type="button" class="btn">보기</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        
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
