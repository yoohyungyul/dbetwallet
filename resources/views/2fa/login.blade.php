@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 col-offset-2">
            <div class="panel panel-default">
                <div class="panel-body mt70">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/2fa/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-4 control-label">OTP CODE</label>

                            <div class="col-6">
                                <input id="totp" type="text" class="form-control" name="totp" value="" maxlength="6">

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-5">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    

</script>
@endsection