<?php
// ===== Kết nối và lấy dữ liệu sản phẩm từ database =====
$products = [];
$conn = new mysqli('localhost', 'root', '', 'webnoithat'); // Kết nối MySQL
$conn->set_charset("utf8"); // Đặt charset UTF-8
$result = $conn->query("SELECT tensp, chatlieu, mau, hinhthuc, mota, gia FROM sanpham"); // Lấy dữ liệu sản phẩm
while ($row = $result->fetch_assoc()) {
    // Đưa thông tin sản phẩm vào mảng
    $products[] = "Tên: {$row['tensp']}, Chất liệu: {$row['chatlieu']}, Màu: {$row['mau']}, Hình thức: {$row['hinhthuc']}, Mô tả: {$row['mota']}, Giá: {$row['gia']} VNĐ";
}
$conn->close(); // Đóng kết nối
$productInfo = implode("\n", $products); // Ghép thông tin sản phẩm thành chuỗi

// ===== Khởi tạo session lưu lịch sử chat =====
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['chat_history']) || empty($_SESSION['chat_history'])) {
    // Nếu chưa có lịch sử chat, thêm tin nhắn chào của bot
    $_SESSION['chat_history'] = [
        [
            'role' => 'bot',
            'text' => 'Chào bạn! Rất vui được hỗ trợ bạn. Bạn cần tư vấn về sản phẩm nội thất nào vậy ạ?',
            'time' => time()
        ]
    ];
}

// ===== Xử lý xóa lịch sử chat khi nhấn nút "Xóa lịch sử" =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear'])) {
    // Xóa lịch sử chat (session)
    $_SESSION['chat_history'] = [];
    // Reload lại trang để cập nhật giao diện
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>webnoithat</title>
    <style>
        /* ===== Giao diện tổng thể ===== */
        body {
            background: #f8f6f1;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .chat-container {
            width: 380px;
            margin: 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            border: 2px solid #f7e9b6;
            padding: 0;
            overflow: hidden;
        }
        /* ===== Header chat ===== */
        .chat-header {
            display: flex;
            align-items: center;
            padding: 18px 20px 12px 20px;
            background: #fffbe7;
            border-bottom: 1px solid #f7e9b6;
            position: relative;
        }
        .chat-header img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            margin-right: 12px;
            border: 2px solid #fff;
        }
        .chat-header .info {
            flex: 1;
        }
        .chat-header .info .name {
            font-weight: bold;
            font-size: 16px;
            color: #222;
        }
        .chat-header .info .status {
            font-size: 12px;
            color: #a6a6a6;
        }
        .chat-header .icons {
            display: flex;
            gap: 10px;
        }
        .chat-header .icons span {
            font-size: 18px;
            color: #c2b87c;
            cursor: pointer;
        }
        /* ===== Dropdown menu (dấu 3 chấm) ===== */
        .menu-dropdown {
            position: relative;
            display: inline-block;
        }
        .menu-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #c2b87c;
            padding: 0 4px;
        }
        .menu-content {
            display: none;
            position: absolute;
            right: 0;
            top: 28px;
            background: #fff;
            min-width: 140px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 8px;
            z-index: 10;
            border: 1px solid #f7e9b6;
            padding: 8px 0;
        }
        .menu-content form {
            margin: 0;
        }
        .menu-content .clear-btn {
            width: 100%;
            border-radius: 0;
            padding: 8px 16px;
            background: white;
            color: #222; /* Đổi màu chữ thành đen */
            border: none;
            font-size: 14px;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s;
        }
        .menu-content .clear-btn:hover {
            background: #e9ecef;
        }
        .menu-dropdown.show .menu-content {
            display: block;
        }
        /* ===== Khung chat ===== */
        .chat-box {
            min-height: 120px;
            max-height: 320px;
            overflow-y: auto;
            padding: 18px 16px 12px 16px;
            background: #fff;
        }
        /* ===== Tin nhắn ===== */
        .message {
            display: flex;
            margin-bottom: 10px;
        }
        .message.user {
            justify-content: flex-end;
        }
        .message.bot {
            justify-content: flex-start;
        }
        .bubble {
            max-width: 75%;
            padding: 10px 16px;
            border-radius: 18px 18px 4px 18px;
            font-size: 15px;
            line-height: 1.5;
            position: relative;
            word-break: break-word;
        }
        .message.user .bubble {
            background: #bfa52f;
            color: #fff;
            border-radius: 18px 18px 4px 18px;
            margin-left: 40px;
        }
        .message.bot .bubble {
            background: #f1f0f0;
            color: #222;
            border-radius: 18px 18px 18px 4px;
            margin-right: 40px;
        }
        .bubble .time {
            display: block;
            font-size: 11px;
            color: #bdbdbd;
            margin-top: 4px;
            text-align: right;
        }
        /* ===== Form nhập chat ===== */
        .chat-form {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 16px 14px 16px;
            background: #fffbe7;
            border-top: 1px solid #f7e9b6;
        }
        .chat-form textarea {
            flex: 1;
            resize: none;
            border-radius: 18px;
            border: 1px solid #e0e0e0;
            padding: 10px 14px;
            font-size: 15px;
            background: #fff;
            outline: none;
            min-height: 36px;
            max-height: 60px;
        }
        .chat-form button {
            background: #bfa52f;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .chat-form button:hover {
            background: #a08c23;
        }
        /* ===== Spinner hiệu ứng loading ===== */
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            background: #222;
            border-radius: 4px;
            animation: spin 0.8s linear infinite;
            margin: 0 8px;
            vertical-align: middle;
        }
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- ===== Header chat với avatar, tên, trạng thái, menu ===== -->
        <div class="chat-header">
            <img src="https://i.pinimg.com/236x/2f/08/ab/2f08ab311cb92ed2cfafc691b12a8ce2.jpg" alt="Avatar">
            <div class="info">
                <div class="status">chat whit</div>
                <div class="name">Tdth</div>
            </div>
            <div class="icons">
                <!-- Dropdown menu dấu 3 chấm -->
                <div class="menu-dropdown" id="menuDropdown">
                    <button class="menu-btn" id="menuBtn" title="More">&#8942;</button>
                    <div class="menu-content" id="menuContent">
                        <form id="clearFormDropdown">
                            <button class="clear-btn" type="submit">Xóa lịch sử</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===== Khung chat hiển thị lịch sử ===== -->
        <div class="chat-box" id="chatBox">
            <?php if (!empty($_SESSION['chat_history'])): ?>
                <?php foreach ($_SESSION['chat_history'] as $msg): ?>
                    <div class="message <?php echo $msg['role']; ?>">
                        <div class="bubble">
                            <?php echo nl2br(htmlspecialchars($msg['text'])); ?>
                            <span class="time"><?php echo date('H:i', $msg['time'] ?? time()); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- Hiệu ứng loading khi chờ trả lời -->
            <div id="loading" style="display:none;">
                <div class="message bot">
                    <div class="bubble">
                        <span class="spinner"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===== Form nhập tin nhắn ===== -->
        <form class="chat-form" id="chatForm" autocomplete="off">
            <textarea name="userInput" id="userInput" rows="1" placeholder="Type your message here..." required></textarea>
            <button type="submit" title="Send">&#10148;</button>
        </form>
    </div>
    <script>
        // ===== Gửi tin nhắn khi nhấn Enter (không giữ Shift) =====
        document.getElementById('userInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('chatForm').dispatchEvent(new Event('submit'));
            }
        });

        // ===== Xử lý gửi tin nhắn bằng AJAX =====
        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var userInput = document.getElementById('userInput').value.trim();
            if (!userInput) return;
            document.getElementById('userInput').value = '';

            // Hiện hiệu ứng loading
            var chatBox = document.getElementById('chatBox');
            var loadingDiv = document.getElementById('loading');
            loadingDiv.style.display = 'block';
            chatBox.scrollTop = chatBox.scrollHeight;

            // Gửi dữ liệu lên server qua AJAX
            fetch('chat_api.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'userInput=' + encodeURIComponent(userInput)
            })
            .then(response => response.json())
            .then(data => {
                loadingDiv.style.display = 'none';
                document.getElementById('userInput').focus();

                // Cập nhật lại chat box với lịch sử mới từ server
                chatBox.innerHTML = '';
                data.history.forEach(function(msg) {
                    var div = document.createElement('div');
                    div.className = 'message ' + msg.role;
                    var bubble = document.createElement('div');
                    bubble.className = 'bubble';
                    bubble.innerHTML = msg.text.replace(/\n/g, '<br>') +
                        '<span class="time">' + (msg.time ? new Date(msg.time * 1000).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '') + '</span>';
                    div.appendChild(bubble);
                    chatBox.appendChild(div);
                });
                // Thêm lại hiệu ứng loading (ẩn)
                chatBox.appendChild(loadingDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            });
        });

        // ===== Dropdown menu toggle cho dấu 3 chấm =====
        const menuBtn = document.getElementById('menuBtn');
        const menuDropdown = document.getElementById('menuDropdown');
        document.addEventListener('click', function(e) {
            // Ẩn menu nếu click ra ngoài
            if (!menuDropdown.contains(e.target)) {
                menuDropdown.classList.remove('show');
            }
        });
        menuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            menuDropdown.classList.toggle('show');
        });

        // ===== Xử lý xóa lịch sử chat qua AJAX =====
        document.getElementById('clearFormDropdown').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('chat_api.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'clear_history=1'
            })
            .then(response => response.json())
            .then(data => {
                // Xóa lịch sử trên giao diện (chỉ còn loading)
                const chatBox = document.getElementById('chatBox');
                chatBox.innerHTML = '';
                // Thêm lại hiệu ứng loading (ẩn)
                const loadingDiv = document.createElement('div');
                loadingDiv.id = 'loading';
                loadingDiv.style.display = 'none';
                loadingDiv.innerHTML = `
                    <div class="message bot">
                        <div class="bubble">
                            <span class="spinner"></span>
                        </div>
                    </div>
                `;
                chatBox.appendChild(loadingDiv);
                // Ẩn menu sau khi xóa
                menuDropdown.classList.remove('show');
            });
        });

        // ===== Tự động focus khi mở trang =====
        window.onload = function() {
            document.getElementById('userInput').focus();
            var chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        };
    </script>
</body>
</html>