
<div class="modal-body">	
    <video id="preview" style="width:100%;height:100%;"></video>
</div>

<script type="text/javascript">
    let scanner = new Instascan.Scanner(
        { 
            video: document.getElementById('preview') 
        }
    );
    scanner.addListener('scan', function (content) {
        alert(content);
    });
    Instascan.Camera.getCameras().then( cameras => {
        if (cameras.length > 0) {
            scanner.start(cameras[1]);
        } else {
        alert('No cameras found.');
        }
    });
</script>   
