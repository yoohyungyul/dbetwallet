@extends('layouts.master')

@section('title', 'DBET Wallet')


@section('style')

@endsection

@section('content')


{!! session()->get('error') !!}
<div class="row  mt20">
    <div class="col-12">
       <nav>
            <div class="nav nav-tabs nav-fill" >
                <a class="nav-item nav-link "  href="/wallet" >Wallet</a>
                <a class="nav-item nav-link " href="/history" >History</a>
                <a class="nav-item nav-link active"   href="/send" >Send</a>
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
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="/send" method="POST" onsubmit="return write_btn();">
                {{ csrf_field() }}
                @foreach ($errors->all() as $error)
                <div class="text-center">error : {{ $error }}</div>
                @endforeach
                <div class="form-group">
                    <label for="addressFormControlInput">Wallet Address</label>
                    <input type="text" name="address" id="address" class="form-control input-lg" id="addressFormControlInput" placeholder="Wallet Address">
                </div>
                <div class="form-group">
                    <label for="amountFormControlInput">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control input-lg" id="amountFormControlInput" placeholder="0">
                </div>
                <div class="form-group">
                    <label for="amountFormControlInput">OTP</label>
                    <input type="text" name="totp" id="totp" class="form-control input-lg" id="amountFormControlInput" placeholder="OTP" maxlength="6">
                </div>
                <button type="submit" id="withdrawal_btn" class="btn btn-primary btn-block">SEND</button>
                </form>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input id="scanner_input" class="form-control" placeholder="Click the button to scan an EAN..." type="text" /> 
                            <span class="input-group-btn"> 
                                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#livestream_scanner">
                                    <i class="fa fa-barcode"></i>
                                </button> 
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                <div class="modal" id="livestream_scanner">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Barcode Scanner</h4>
                            </div>
                            <div class="modal-body" style="position: static">
                                <div id="interactive" class="viewport"></div>
                                <div class="error"></div>
                            </div>
                            <div class="modal-footer">
                                <label class="btn btn-default pull-left">
                                    <i class="fa fa-camera"></i> Use camera app
                                    <input type="file" accept="image/*;capture=camera" capture="camera" class="hidden" />
                                </label>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <style>
	#interactive.viewport {position: relative; width: 100%; height: auto; overflow: hidden; text-align: center;}
	#interactive.viewport > canvas, #interactive.viewport > video {max-width: 100%;width: 100%;}
	canvas.drawing, canvas.drawingBuffer {position: absolute; left: 0; top: 0;}
</style>


            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script>
    
    function write_btn() {
	
        var btn = $('#withdrawal_btn');
        btn.attr('disabled','disabled');
        setTimeout(function() {
        btn.removeAttr('disabled');
        }, 1000);


        if($('#address').val() == '') {
            $('#address').focus();
            alert("address. ");
            return false;
        }
        
    
        if($('#amount').val() == '') {
            $('#amount').focus();
            alert("amount. ");
            return false;
        }

        if($('#amount').val() == '0') {
            $('#amount').focus();
            alert("amount. ");
            return false;
        }


        if($('#totp').val() == '') {
            $('#totp').focus();
            alert("totp. ");
            return false;
        }

        return true;
    }


    $(function() {
	// Create the QuaggaJS config object for the live stream
	var liveStreamConfig = {
			inputStream: {
				type : "LiveStream",
				constraints: {
					width: {min: 640},
					height: {min: 480},
					aspectRatio: {min: 1, max: 100},
					facingMode: "environment" // or "user" for the front camera
				}
			},
			locator: {
				patchSize: "medium",
				halfSample: true
			},
			numOfWorkers: (navigator.hardwareConcurrency ? navigator.hardwareConcurrency : 4),
			decoder: {
				"readers":[
					{"format":"ean_reader","config":{}}
				]
			},
			locate: true
		};
	// The fallback to the file API requires a different inputStream option. 
	// The rest is the same 
	var fileConfig = $.extend(
			{}, 
			liveStreamConfig,
			{
				inputStream: {
					size: 800
				}
			}
		);
	// Start the live stream scanner when the modal opens
	$('#livestream_scanner').on('shown.bs.modal', function (e) {
		Quagga.init(
			liveStreamConfig, 
			function(err) {
				if (err) {
					$('#livestream_scanner .modal-body .error').html('<div class="alert alert-danger"><strong><i class="fa fa-exclamation-triangle"></i> '+err.name+'</strong>: '+err.message+'</div>');
					Quagga.stop();
					return;
				}
				Quagga.start();
			}
		);
    });
	
	// Make sure, QuaggaJS draws frames an lines around possible 
	// barcodes on the live stream
	Quagga.onProcessed(function(result) {
		var drawingCtx = Quagga.canvas.ctx.overlay,
			drawingCanvas = Quagga.canvas.dom.overlay;
 
		if (result) {
			if (result.boxes) {
				drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
				result.boxes.filter(function (box) {
					return box !== result.box;
				}).forEach(function (box) {
					Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
				});
			}
 
			if (result.box) {
				Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
			}
 
			if (result.codeResult && result.codeResult.code) {
				Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
			}
		}
	});
	
	// Once a barcode had been read successfully, stop quagga and 
	// close the modal after a second to let the user notice where 
	// the barcode had actually been found.
	Quagga.onDetected(function(result) {    		
		if (result.codeResult.code){
			$('#scanner_input').val(result.codeResult.code);
			Quagga.stop();	
			setTimeout(function(){ $('#livestream_scanner').modal('hide'); }, 1000);			
		}
	});
    
	// Stop quagga in any case, when the modal is closed
    $('#livestream_scanner').on('hide.bs.modal', function(){
    	if (Quagga){
    		Quagga.stop();	
    	}
    });
	
	// Call Quagga.decodeSingle() for every file selected in the 
	// file input
	$("#livestream_scanner input:file").on("change", function(e) {
		if (e.target.files && e.target.files.length) {
			Quagga.decodeSingle($.extend({}, fileConfig, {src: URL.createObjectURL(e.target.files[0])}), function(result) {alert(result.codeResult.code);});
		}
	});
});
   
</script>
@endsection
