<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Receipt with QR Code</title>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>
<body>

    <form id="myForm">
        <!-- Đặt nội dung của biểu mẫu ở đây -->
    </form>

    <img id="qrCodeImage" src="" style="display: none;"> <!-- Thêm hình ảnh QR code, ẩn nó ngay từ đầu -->

    <script>
        function printForm() {
            var form = document.getElementById("myForm");
            var printWindow = window.open('', '_blank');
            var formClone = form.cloneNode(true);
            var styles = document.head.innerHTML;
            var footer = "Mọi thông tin vui lòng liên hệ lillyflower để được hỗ trợ.";
            var sodienthoai = "Số Điện Thoại: 0974 9999 08";
            var website = "Website: www.lillyflower.com.vn";
            var address = "Địa chỉ: 593 Trần Hưng Đạo, Quận 1, HCM";

            var printDocument = printWindow.document;
            printDocument.open();
            printDocument.write('<html><head>' + styles + '<center><img src="https://banhang.lillyflower.com.vn/admin/img/logo.png" width=200px"><h2 style="font-size:28px">Biên Nhận</h2></center></head><body>');

            // Thêm nội dung của biểu mẫu
            printDocument.body.appendChild(formClone);
            printDocument.body.innerHTML += '<br>';

            // Hiển thị hình ảnh QR code
            var qrCodeImage = document.getElementById("qrCodeImage");
            qrCodeImage.src = generateQRCode("https://www.example.com"); // Thay thế bằng nội dung thực tế của bạn
            qrCodeImage.style.display = "block";

            printDocument.body.appendChild(qrCodeImage);

            printDocument.body.innerHTML += '<div style="font-size: 10px;">' + footer + '</div>';
            printDocument.body.innerHTML += '<div style="font-size: 10px;">' + sodienthoai + '</div>';
            printDocument.body.innerHTML += '<div style="font-size: 10px;">' + website + '</div>';
            printDocument.body.innerHTML += '<div style="font-size: 10px;">' + address + '</div>';
            printDocument.write('</body></html>');
            printDocument.close();

            setTimeout(function () {
                printWindow.print();
                printWindow.close();
            }, 1000);
        }

        function generateQRCode(text) {
            var qrCodeDiv = document.createElement("div");
            var qrcode = new QRCode(qrCodeDiv, {
                text: text,
                width: 100,
                height: 100
            });
            var qrCodeImage = new Image();
            qrCodeImage.src = qrCodeDiv.firstChild.toDataURL("image/png");
            return qrCodeImage.src;
        }
    </script>

    <button onclick="printForm()">In Biên Nhận</button>

</body>
</html>
