<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quét QR Code</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            margin-bottom: 20px;
        }

        #video-container {
            display: none;
            position: relative;
            width: 80%;
            max-width: 400px;
            overflow: hidden;
            border: 2px solid #333;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        #video-preview {
            width: 100%;
            height: auto;
        }

        #result {
            margin-top: 10px;
            font-size: 16px;
        }

        #input-container {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #input-result {
            margin-top: 5px;
            padding: 8px;
            font-size: 14px;
            width: 80%;
            max-width: 300px;
        }

        button {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Quét QR Code</h1>

    <div id="video-container">
        <video id="video-preview"></video>
    </div>

    <div id="result"></div>

    <div id="input-container">
        <input type="text" id="input-result" placeholder="ID từ mã QR code" readonly onclick="startScanner()">
        <button onclick="toggleCamera()">Chuyển đổi Camera</button>
    </div>

    <script>
        let video = document.getElementById('video-preview');
        let canvasElement = document.createElement('canvas');
        let canvas = canvasElement.getContext('2d');
        let loadingMessage = document.getElementById('result');
        let inputResult = document.getElementById('input-result');
        let scanning = false;
        let facingMode = 'user';

        function startScanner() {
            document.getElementById('video-container').style.display = 'block';

            navigator.mediaDevices.enumerateDevices()
                .then(devices => {
                    let constraints;
                    devices.forEach(device => {
                        if (device.kind === 'videoinput') {
                            constraints = {
                                video: {
                                    deviceId: { exact: device.deviceId },
                                    facingMode: facingMode,
                                },
                            };
                        }
                    });

                    return navigator.mediaDevices.getUserMedia(constraints);
                })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.play();
                    requestAnimationFrame(tick);
                    scanning = true;
                })
                .catch(function (error) {
                    console.error('Lỗi truy cập camera:', error);
                });
        }

        function toggleCamera() {
            facingMode = (facingMode === 'user') ? 'environment' : 'user';

            if (video.srcObject) {
                let tracks = video.srcObject.getTracks();
                tracks[0].stop();
                video.srcObject = null;
                scanning = false;
                document.getElementById('video-container').style.display = 'none';
            }

            startScanner();
        }

        function tick() {
            if (scanning) {
                loadingMessage.innerText = 'Đang quét...';
                if (video.readyState === video.HAVE_ENOUGH_DATA) {
                    canvasElement.width = video.videoWidth;
                    canvasElement.height = video.videoHeight;
                    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                    let imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                    let code = jsQR(imageData.data, imageData.width, imageData.height, {
                        inversionAttempts: 'dontInvert',
                    });
                    if (code) {
                        handleScannedID(code.data);
                    }
                }
                requestAnimationFrame(tick);
            }
        }

        function handleScannedID(id) {
            console.log('Đã nhận được ID từ mã QR code:', id);
            loadingMessage.innerText = 'ID từ mã QR code: ' + id;
            inputResult.value = id;
            scanning = false;
            toggleCamera();
        }
    </script>

    <script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
</body>
</html>
