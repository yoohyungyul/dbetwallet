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

        <table class="table table-hover" style="table-layout: fixed;word-wrap: break-word;">
            <thead>
                <tr>
                <th scope="col" width="20%">DATE</th>
                <th scope="col" width="40%">ADDRESS</th>
                <th scope="col" width="20%">AMOUNT</th>
                <th scope="col" width="20%">BALANCE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $data)
                <tr>
                    <td>{{$data}}</td>
                    <td>
                        
                    </td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>
    @if($list)
    <div class="col-12">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="{{ url('history') }}?page={{ $paging->prev }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                @for ($i=$paging->paging_start; $i<=$paging->paging_end; $i++)
                <li class="page-item"><a class="page-link" href="{{ url('history') }}?page={{ $i }}">{{ $i+1 }}</a></li>
                @endfor
                <li class="page-item">
                <a class="page-link" href="{{ url('history') }}?page={{ $paging->next }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</div>



@endsection


@section('script')
<script>
    

</script>
@endsection
