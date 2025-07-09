<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['txtUsername'] ?? '');
    $password = trim($_POST['txtPassword'] ?? '');

    // Kết nối MySQL
    $conn = new mysqli('localhost', 'root', '', 'webnoithat');
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Truy vấn kiểm tra tài khoản
    $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE taikhoan = ? AND matkhau = ?");
    if (!$stmt) {
        die("Lỗi prepare: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: trangchu.php");
        exit;
    } else {
        $error = "Sai tài khoản hoặc mật khẩu";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
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
    <div class="relative w-full md:w-1/2 bg-cover bg-center" style="background-image: url('NỘI THẤT.png');">
        <h1 class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
        text-white text-6xl font-bold shadow-lg rotate-3 text-center" style="font-family:Museo Moderno ;">
        </h1>
    </div>
    <div class="flex items-center justify-center w-full md:w-1/2 bg-[#FAF4EE]">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-sm">
            <h2 class="text-black text-lg font-bold uppercase text-center mb-6" style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">ĐĂNG NHẬP</h2>
            <?php if ($error): ?>
                <div class="mb-4 text-red-600 text-center font-semibold"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post" autocomplete="off">
                <div class="mb-4">
                    <label class="block text-zinc-700 text-sm font-bold mb-2" for="txtUsername">TÊN ĐĂNG</label>
                    <input type="text" id="txtUsername" name="txtUsername" class="border rounded-lg w-full py-2 px-3 text-zinc-700 focus:border-[#C4A484] transition duration-200" placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="mb-6">
                    <label class="block text-zinc-700 text-sm font-bold mb-2" for="txtPassword">MẬT KHẨU</label>
                    <input type="password" id="txtPassword" name="txtPassword" class="border rounded-lg w-full py-2 px-3 text-zinc-700 focus:border-[#C4A484] transition duration-200" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="bg-[#C4A484] text-white font-bold uppercase rounded-lg py-2 w-full hover:bg-[#BFA68A] transition duration-200">ĐĂNG NHẬP</button>
            </form>
            <div class="flex justify-between mt-4 text-zinc-600 text-sm">
                <a href="dangky.php" class="text-center hover:underline">ĐĂNG KÝ TÀI KHOẢN</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
