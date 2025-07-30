<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tra Cứu Đơn Hàng</title>
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

        #data-container {
            margin-top: 10px;
            font-size: 16px;
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
    <center>

        <a href="/admin/"><img src="/admin/img/logo.png" width="250px"></a><br/>
    </center>
    <h1>Tra Cứu Đơn Hàng</h1>

    <div id="video-container">
        <video id="video-preview" playsinline></video>
    </div>

    <div id="result"></div>

    <div id="input-container">
        <?php 
            $id_bill = $_GET['idbill']; 
            if($id_bill!=""){
                ?><input type="text" id="input-result" placeholder="Mã Đơn Hàng" readonly onclick="startScanner()" value="<?php echo $id_bill; ?>"><?php
            }else{
                ?><input type="text" id="input-result" placeholder="Mã Đơn Hàng" readonly onclick="startScanner()" ><?php
            }
        ?>
        
        <!--<button>Tra Cứu</button>-->
        <!--<button onclick="toggleCamera()">Chuyển đổi Camera</button>-->
    </div>

    <div id="data-container">
        <!-- Hiển thị dữ liệu từ cơ sở dữ liệu sau khi quét thành công -->
    </div>

    <script>
        let video = document.getElementById('video-preview');
        let canvasElement = document.createElement('canvas');
        let canvas = canvasElement.getContext('2d');
        let loadingMessage = document.getElementById('result');
        let inputResult = document.getElementById('input-result');
        let scanning = false;
        let facingMode = 'environment';

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
            if (!scanning) {
                startScanner();
            } else {
                facingMode = (facingMode === 'user') ? 'environment' : 'user';

                if (video.srcObject) {
                    let tracks = video.srcObject.getTracks();
                    tracks[0].stop();
                    video.srcObject = null;
                    scanning = false;
                    document.getElementById('video-container').style.display = 'none';
                }
            }
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
            document.getElementById('video-container').style.display = 'none';
            stopCamera();

            // Gửi ID đến process.php để lấy dữ liệu từ cơ sở dữ liệu
            fetch('process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id,
            })
            .then(response => response.json())
            .then(data => {
                console.log('Dữ liệu nhận được từ process.php:', data); // Thêm dòng này để kiểm tra dữ liệu
                if (data !="") {
                    // Hiển thị dữ liệu từ cơ sở dữ liệu
                    let dataContainer = document.getElementById('data-container');
                    dataContainer.innerHTML = `
                    <form action="updatestatus.php" method="POST">
                        <p><strong>Tên khách hàng:</strong> ${data.customerName}</p>
                        <p><strong>Số điện thoại:</strong> <a href="tel:0${data.phoneNumber}">0${data.phoneNumber}</a></p>
                        <p><strong>Địa chỉ giao hàng:</strong><a href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.deliveryAddress + ' ' + data.deliveryAddress1 + ' ' + data.deliveryAddress2 + ' ' + data.deliveryAddress3 + ' ' + data.deliveryAddress4)}" target="_blank"> <br/>${data.deliveryAddress}, Đường ${data.deliveryAddress1},<br/> ${data.deliveryAddress2},<br/> ${data.deliveryAddress3},<br/> ${data.deliveryAddress4}</a></p>
                        <p><strong>Số tiền phải thu:</strong> ${formatCurrency(data.amountDue)} VNĐ</p>
                        <p><strong>Tình trạng giao hàng:</strong> ${data.statusShipping}</p>
                        <p><strong>Ảnh Sản Phẩm:</strong><br/> <center><a href="${data.Urlimage}"><img src=${data.Urlimage} width=350px></a></center></p>
                        <input type="text" name="id" value="${data.idBilling}" hidden></input>
                        <!--<center><button id="giaoHangButton"><a style="color:white;text-decoration: none; display:none" href='updatestatus.php/?id=${data.idBilling}'>GIAO HÀNG</a></button></center>-->
                        <center><button id="giaoHangButton" style="display:block">GIAO HÀNG</button></center>
                        
                    </form>

                    `;
                } else {
                    // Xử lý trường hợp ID không tồn tại
                    document.getElementById('data-container').innerText = 'ID không tồn tại trong cơ sở dữ liệu.';
                }
            })
            .catch(error => console.error('Lỗi khi gửi yêu cầu đến process.php:', error));
                    }

        function stopCamera() {
            if (video.srcObject) {
                let tracks = video.srcObject.getTracks();
                tracks.forEach(track => track.stop());
                video.srcObject = null;
            }
        }

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy giá trị idStatusShipping từ dữ liệu
            var idStatusShipping = ${data.idStatusShipping};

            // Kiểm tra nếu idStatusShipping là 1 thì hiển thị nút "GIAO HÀNG"
            if (idStatusShipping === 1) {
                var giaoHangButton = document.getElementById('giaoHangButton');
                giaoHangButton.style.display = 'block';
            }
        });
    </script>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Kiểm tra nếu có giá trị idbill
                var idBillParam = getParameterByName('idbill');
                
                if (idBillParam) {
                    // Gọi hàm handleScannedID với giá trị idbill
                    handleScannedID(idBillParam);
                }
            });

    function getParameterByName(name) {
        var url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
    </script>

    <script>
          function formatCurrency(amount) {
        // Sử dụng đối tượng Intl.NumberFormat để định dạng số tiền với dấu phân cách
        const formatter = new Intl.NumberFormat('vi-VN', {
          minimumFractionDigits: 0,
        });

        // Áp dụng định dạng và trả về chuỗi số tiền đã định dạng
        return formatter.format(amount);
      }
      //Xác Nhận Giao Hàng 
      function myFunction(id) {
        var r = confirm("Xác Nhận Đã Giao Hàng Chưa?");
        if (r == true) {
           $.ajax({
                url : "shipping-done.php",
                type : "post",
                dataType:"text",
                data : {id : id},
                success : function (result){
                  //alert (result);
                  if (result==1){
                    alert ("Hoàn Thành Đơn Hàng!");
                    location.reload();
                  }
                  //$('#result').html(result);
                }
              });
        }
        else{
          //
        }
      }
    </script>
    <script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
</body>
</html>
