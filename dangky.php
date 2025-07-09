<?php
// Xử lý đăng ký
// Biến $alert dùng để lưu thông báo lỗi hoặc thành công
$alert = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form gửi lên, loại bỏ khoảng trắng đầu cuối
    $tentaikhoan = trim($_POST['tentaikhoan'] ?? '');
    $matkhau = trim($_POST['matkhau'] ?? '');
    $diachi = trim($_POST['diachi'] ?? '');
    $sdt = trim($_POST['sdt'] ?? '');

    // Kết nối tới cơ sở dữ liệu MySQL (sửa lại thông tin nếu cần)
    $conn = new mysqli('localhost', 'root', '', 'webnoithat');
    if ($conn->connect_error) {
        // Nếu kết nối thất bại, lưu thông báo lỗi vào biến $alert
        $alert = "Kết nối thất bại: " . $conn->connect_error;
    } else {
        // Kiểm tra xem tên đăng nhập đã tồn tại trong bảng taikhoan chưa
        $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE taikhoan = ?");
        $stmt->bind_param("s", $tentaikhoan);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Nếu đã tồn tại, thông báo lỗi
            $alert = "Tên đăng nhập đã tồn tại! Vui lòng chọn tên khác.";
        } else {
            // Nếu chưa tồn tại, tiến hành thêm tài khoản mới
            // Mã hóa mật khẩu trước khi lưu vào CSDL để tăng bảo mật
            $hashed_password = password_hash($matkhau, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO taikhoan (taikhoan, matkhau, diachi, sdt) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $tentaikhoan, $hashed_password, $diachi, $sdt);
            if ($stmt->execute()) {
                // Nếu thêm thành công, hiển thị thông báo và chuyển hướng sang trang đăng nhập
                echo "<script>alert('Đăng ký thành công!'); window.location='dangnhap.php';</script>";
                exit;
            } else {
                // Nếu thêm thất bại, thông báo lỗi
                $alert = "Đăng ký không thành công!";
            }
        }
        // Đóng statement và kết nối
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <!-- Phần cấu hình Tailwind và style giữ nguyên như bản gốc -->
    <script type="text/javascript">
        window.tailwind = window.tailwind || {};
        window.tailwind.config = {
            darkMode: ['class'],
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))'
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))'
                        },
                        destructive: {
                            DEFAULT: 'hsl(var(--destructive))',
                            foreground: 'hsl(var(--destructive-foreground))'
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))'
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))'
                        },
                        popover: {
                            DEFAULT: 'hsl(var(--popover))',
                            foreground: 'hsl(var(--popover-foreground))'
                        },
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))'
                        },
                    },
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            :root {
                --background: 0 0% 100%;
                --foreground: 240 10% 3.9%;
                --card: 0 0% 100%;
                --card-foreground: 240 10% 3.9%;
                --popover: 0 0% 100%;
                --popover-foreground: 240 10% 3.9%;
                --primary: 240 5.9% 10%;
                --primary-foreground: 0 0% 98%;
                --secondary: 240 4.8% 95.9%;
                --secondary-foreground: 240 5.9% 10%;
                --muted: 240 4.8% 95.9%;
                --muted-foreground: 240 3.8% 46.1%;
                --accent: 240 4.8% 95.9%;
                --accent-foreground: 240 5.9% 10%;
                --destructive: 0 84.2% 60.2%;
                --destructive-foreground: 0 0% 98%;
                --border: 240 5.9% 90%;
                --input: 240 5.9% 90%;
                --ring: 240 5.9% 10%;
                --radius: 0.5rem;
            }
            .dark {
                --background: 240 10% 3.9%;
                --foreground: 0 0% 98%;
                --card: 240 10% 3.9%;
                --card-foreground: 0 0% 98%;
                --popover: 240 10% 3.9%;
                --popover-foreground: 0 0% 98%;
                --primary: 0 0% 98%;
                --primary-foreground: 240 5.9% 10%;
                --secondary: 240 3.7% 15.9%;
                --secondary-foreground: 0 0% 98%;
                --muted: 240 3.7% 15.9%;
                --muted-foreground: 240 5% 64.9%;
                --accent: 240 3.7% 15.9%;
                --accent-foreground: 0 0% 98%;
                --destructive: 0 62.8% 30.6%;
                --destructive-foreground: 0 0% 98%;
                --border: 240 3.7% 15.9%;
                --input: 240 3.7% 15.9%;
                --ring: 240 4.9% 83.9%;
            }
        }
    </style>
</head>
<body>
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Cột bên trái: Ảnh nền -->
        <div class="flex-1 bg-cover bg-center" style="background-image: url('NỘI THẤT.png');">
        </div>
        <!-- Cột bên phải: Form đăng ký -->
        <div class="flex-1 flex items-center justify-center bg-neutral-100" style="background-color:#fcf8ef">
            <form method="post" class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
                <h2 class="text-black text-lg font-bold uppercase text-center mb-6" style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">ĐĂNG KÝ</h2>
                <!-- Hiển thị thông báo lỗi hoặc thành công nếu có -->
                <?php if ($alert): ?>
                    <div class="mb-4 text-red-600 text-center"><?= htmlspecialchars($alert) ?></div>
                <?php endif; ?>
                <!-- Trường nhập tên đăng nhập -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-zinc-700" for="tentaikhoan">TÊN ĐĂNG NHẬP</label>
                    <input type="text" id="tentaikhoan" name="tentaikhoan" class="mt-1 block w-full border border-zinc-300 rounded-md p-2" placeholder="Nhập tên đăng nhập" required>
                </div>
                <!-- Trường nhập mật khẩu -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-zinc-700" for="matkhau">MẬT KHẨU</label>
                    <input type="password" id="matkhau" name="matkhau" class="mt-1 block w-full border border-zinc-300 rounded-md p-2" placeholder="Nhập mật khẩu" required>
                </div>
                <!-- Trường nhập địa chỉ -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-zinc-700" for="diachi">ĐỊA CHỈ</label>
                    <input type="text" id="diachi" name="diachi" class="mt-1 block w-full border border-zinc-300 rounded-md p-2" placeholder="Nhập địa chỉ" required>
                </div>
                <!-- Trường nhập số điện thoại -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-zinc-700" for="sdt">SỐ ĐIỆN THOẠI</label>
                    <input type="text" id="sdt" name="sdt" class="mt-1 block w-full border border-zinc-300 rounded-md p-2" placeholder="Nhập số điện thoại" required>
                </div>
                <!-- Nút đăng ký tài khoản -->
                <button type="submit" class="bg-primary text-white py-2 rounded-lg w-full hover:bg-primary/80">ĐĂNG KÝ TÀI KHOẢN</button>
                <!-- Link chuyển sang trang đăng nhập -->
                <p class="mt-4 text-center text-sm text-zinc-600"><a href="dangnhap.php">ĐĂNG NHẬP TÀI KHOẢN</a></p>
            </form>
        </div>
    </div>
</body>
</html>
