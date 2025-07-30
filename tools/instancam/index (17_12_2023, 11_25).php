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
            display: none; /* Ẩn video container khi chưa bấm vào input */
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

        @keyframes scan {
            0% {
                transform: translateY(-100%);
            }
            100% {
                transform: translateY(100%);
            }
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
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
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
        let scanner;
        let currentCamera = 'user'; // 'user' là camera trước, 'environment' là camera sau

        function toggleCamera() {
            // Đảo ngược giữa camera trước và camera sau
            currentCamera = (currentCamera === 'user') ? 'environment' : 'user';
            // Dừng quét và bắt đầu lại với camera mới
            if (scanner) {
                scanner.stop();
                startScanner();
            }
        }

        function startScanner() {
            // Hiển thị video container khi bắt đầu quét
            document.getElementById('video-container').style.display = 'block';

            // Bắt đầu quét từ camera được chọn
            navigator.mediaDevices.getUserMedia({ video: { facingMode: currentCamera } })
                .then(function (stream) {
                    scanner = new Instascan.Scanner({ video: document.getElementById('video-preview'), mirror: false });
                    scanner.addListener('scan', function (content) {
                        // Gửi ID được quét tới máy chủ PHP để xử lý
                        handleScannedID(content);
                    });
                    document.getElementById('video-preview').srcObject = stream;
                    scanner.start(stream.getTracks()[0]);
                })
                .catch(function (error) {
                    console.error('Lỗi truy cập camera:', error);
                });
        }

        // Hàm để xử lý ID từ mã QR code
        function handleScannedID(id) {
            console.log('Đã nhận được ID từ mã QR code:', id);
            document.getElementById('result').innerText = 'ID từ mã QR code: ' + id;
            document.getElementById('input-result').value = id;

            // Dừng quét và ẩn video container sau khi đã nhận được ID
            scanner.stop();
            document.getElementById('video-container').style.display = 'none';

            // Thực hiện các xử lý khác tại đây nếu cần
        }
    </script>
</body>
</html>
