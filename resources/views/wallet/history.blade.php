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
                <th scope="col" width="60%">Txid</th>
                <th scope="col" width="20%">Date</th>
                <th scope="col" width="20%">Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                <tr>
                <td>0xaaed4eb400d7ab2f237bf9c3eda2e3e8173f0c6a</td>
                <td>Otto</td>
                <td>@mdo</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="dataTables_paginate paging_full_numbers">
                    <a href="{{ url('admin/safeaddress') }}/{{ $paging->start }}" class="first paginate_button paginate_button_disabled">First</a>
                    <a href="{{ url('admin/safeaddress') }}/{{ $paging->prev }}" class="previous paginate_button paginate_button_disabled">Previous</a>
                    <span>
@for ($i=$paging->paging_start; $i<=$paging->paging_end; $i++)
                        <a href="{{ url('admin/safeaddress') }}/{{ $i }}" class="{{ ($i==$paging->page)?'paginate_active':'paginate_button' }}">{{ $i+1 }}</a>
@endfor
                    </span>
                    <a href="{{ url('admin/safeaddress') }}/list/{{ $paging->next }}" class="next paginate_button">Next</a>
                    <a href="{{ url('admin/safeaddress') }}/list/{{ $paging->end }}" class="last paginate_button">Last</a>
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
