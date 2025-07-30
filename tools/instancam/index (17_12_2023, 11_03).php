<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quét QR Code</title>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>
    <h1>Quét QR Code</h1>

    <video id="video-preview"></video>
    <button onclick="toggleCamera()">Chuyển đổi Camera</button>

    <script>
        let scanner;
        let currentCamera = 0; // 0 là camera trước, 1 là camera sau

        function toggleCamera() {
            if (scanner) {
                scanner.stop();
                currentCamera = 1 - currentCamera; // Chuyển đổi giữa 0 và 1
                startScanner();
            }
        }

        function startScanner() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: currentCamera === 0 ? "user" : "environment" } })
                .then(function (stream) {
                    scanner = new Instascan.Scanner({ video: document.getElementById('video-preview'), mirror: false });
                    scanner.addListener('scan', function (content) {
                        // Gửi ID được quét tới máy chủ PHP để xử lý
                        sendIDToServer(content);
                    });
                    document.getElementById('video-preview').srcObject = stream;
                    scanner.start(stream.getTracks()[0]);
                })
                .catch(function (error) {
                    console.error('Lỗi truy cập camera:', error);
                });
        }

        // Bắt đầu quét từ camera mặc định (trước)
        startScanner();

        // Hàm để gửi ID tới máy chủ PHP
        function sendIDToServer(id) {
            // Sử dụng AJAX để gửi dữ liệu tới máy chủ
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'process.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Xử lý phản hồi từ máy chủ (nếu cần)
                    console.log(xhr.responseText);
                }
            };
            xhr.send('id=' + id);
        }
    </script>
</body>
</html>
