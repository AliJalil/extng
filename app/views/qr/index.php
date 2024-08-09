<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="MA-vistitem2" style="padding: 50px">
    <div style="text-align: center">


        <h1>قراءة الرمز من الكاميرا</h1>
        <div id="video-container" style="display: flex; justify-content: center;">
            <video id="qr-video"></video>
        </div>

        <b>يحتوي الجهاز على كاميرا؟: </b>
        <span id="cam-has-camera"></span>

        <br>

        <div>
            <b> اختر جهاز الكامرا لقراءة الرمز:</b>
            <select id="cam-list">
                <option value="environment" selected>الافتراضية</option>
            </select>
        </div>

        <button id="start-button" class="ma-add">تشغيل الكاميرا</button>
        <button id="stop-button" class="ma-add">ايقاف الكاميرا</button>
        <br><span style="display:none" id="cam-qr-result"></span>
<!--        <hr>-->
<!--        <h1>القراءة من ملف:</h1>-->
<!--        <button class="ma-add" style="cursor:pointer" onclick="$('#file-selector').click()">&nbsp; &nbsp;     اختر صورة الرمز لقرائتها-->
<!--            &nbsp; &nbsp; </button>-->
<!--        <input type="file" id="file-selector" style="display:none">-->
        <br><span style="display:none" id="file-qr-result"></span>
    </div>


</div>

<script type="module">
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
            // Camera permission granted
            // Do something with the camera stream
        })
        .catch(function (error) {
            // Camera permission denied or error occurred
            console.log('Error accessing camera: ' + error.message);
        });

    import QrScanner from "<?php echo URLROOT . "/public/vendor/qr-scanner.min.js" ?>";
    // "../qr-scanner.min.js";

    const video = document.getElementById( 'qr-video' );
    const videoContainer = document.getElementById( 'video-container' );
    const camHasCamera = document.getElementById( 'cam-has-camera' );
    const camList = document.getElementById( 'cam-list' );

    const camQrResult = document.getElementById( 'cam-qr-result' );
    // const camQrResultTimestamp = document.getElementById( 'cam-qr-result-timestamp' );
    const fileSelector = document.getElementById( 'file-selector' );
    const fileQrResult = document.getElementById( 'file-qr-result' );

    function setResult(label, result) {
        console.log( result.data );
        label.textContent = result.data;
        // camQrResultTimestamp.textContent = new Date().toString();
        label.style.color = 'teal';
        clearTimeout( label.highlightTimeout );
        label.highlightTimeout = setTimeout( () => label.style.color = 'inherit', 100 );
        window.location = '<?php echo URLROOT . "/detections/addDetectionInfo/0/" ?>' + result.data;
    }

    // ####### Web Cam Scanning #######
    const scanner = new QrScanner( video, result => setResult( camQrResult, result ), {
        onDecodeError: error => {
            camQrResult.textContent = error;
            camQrResult.style.color = 'inherit';
        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    } );


    scanner.start().then( () => {
        // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
        // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
        // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
        // start the scanner earlier.
        QrScanner.listCameras( true ).then( cameras => cameras.foreach( camera => {
            const option = document.createElement( 'option' );
            option.value = camera.id;
            option.text = camera.label;
            camList.add( option );
        } ) );
    } );

    QrScanner.hasCamera().then( hasCamera => camHasCamera.textContent = states.filter( state => state.value == hasCamera )[0].text );

    // for debugging
    window.scanner = scanner;
    scanner.setInversionMode( "both" );
    videoContainer.className = "example-style-1";
    scanner._updateOverlay(); // reposition the highlight because style 2 sets position: relative

    document.getElementById( 'start-button' ).addEventListener( 'click', () => {
        scanner.start();
    } );

    document.getElementById( 'stop-button' ).addEventListener( 'click', () => {
        scanner.stop();
    } );

    // ####### File Scanning #######

    fileSelector.addEventListener( 'change', event => {
        const file = fileSelector.files[0];
        if (!file) {
            return;
        }
        QrScanner.scanImage( file, {returnDetailedScanResult: true} )
            .then( result => setResult( fileQrResult, result ) )
            .catch( e => setResult( fileQrResult, {data: e || 'لا يوجد QR للقراءة'} ) );
    } );
</script>

<style>

    #video-container {
        line-height: 0;
    }

    #qr-video {
        height: 200px;
    }

    #video-container.example-style-1 .scan-region-highlight-svg,
    #video-container.example-style-1 .code-outline-highlight {
        stroke: #64a2f3 !important;
    }

    #video-container.example-style-2 {
        position: relative;
        /*width: max-content;*/
        /*height: max-content;*/
        overflow: hidden;
        height: 200px;
        width: 200px;
    }

    }

    #video-container.example-style-2 .scan-region-highlight {
        border-radius: 30px;
        outline: rgba(0, 0, 0, .25) solid 50vmax;

    }

    #video-container.example-style-2 .scan-region-highlight-svg {
        /*display: none;*/
    }

    #video-container.example-style-2 .code-outline-highlight {
        stroke: rgba(255, 255, 255, .5) !important;
        stroke-width: 15 !important;
        stroke-dasharray: none !important;
    }

    #flash-toggle {
        display: none;
    }

    hr {
        margin-top: 32px;
    }

</style>
</body>
</html>
