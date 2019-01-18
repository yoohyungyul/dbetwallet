<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Instascan</title>
    <script type="text/javascript" src="/js/test.js"></script>
  </head>
  <body>
    <video id="preview" style="width:100%;height:100%;"></video>
    <script type="text/javascript">
    
        // let scanner = new Instascan.Scanner(
        //     { 
        //         video: document.getElementById('preview') 
        //     }
        // );
        // scanner.addListener('scan', function (content) {
        //     // alert(content);
        //    opener.document.getElementById("address").value = content;
        //    self.close();


        // });
        // Instascan.Camera.getCameras().then( cameras => {
        //     if (cameras.length > 0) {
        //         scanner.start(cameras[1]);
        //     } else {
        //     alert('No cameras found.');
        //     }
        // });

        document.addEventListener("DOMContentLoaded", event => {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        Instascan.Camera.getCameras().then(cameras => {
            scanner.camera = cameras[cameras.length - 1];
            scanner.start();
        }).catch(e => console.error(e));

        scanner.addListener('scan', content => {
            console.log(content);
        });

        });
  
    </script>   
  </body>
</html>

