<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Nội Thất</title>
    <!-- Tailwind CDN và các plugin forms, typography -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <!-- Lazy load images -->
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
    <!-- Cấu hình màu sắc cho Tailwind sử dụng biến CSS -->
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
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))'
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))'
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
    <style>
        :root {
            --background: #fff;
            --foreground: #222;
            --primary: #22223b;
            --primary-foreground: #fff;
            --secondary: #CD853F;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
        }
    </style>
        <style>
        nav a {
            color: #222;
            transition: color 0.25s cubic-bezier(.4,0,.2,1);
        }
        nav a:hover, nav a:focus {
            color: #A67C68 !important;
        }
    </style>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = isset($_SESSION['username']) ? strtolower($_SESSION['username']) : null;

// Xác định các link và text cho menu dựa trên trạng thái đăng nhập
if (!$username) {
    $giohang_href = "dangnhap.php";
    $giohang_onclick = "alert('Bạn cần đăng nhập để sử dụng chức năng này!'); return false;";
    $giohang_text = "Giỏ Hàng";

    $thongtin_href = "dangnhap.php";
    $thongtin_onclick = "alert('Bạn cần đăng nhập để sử dụng chức năng này!'); return false;";
    $thongtin_text = "Thông Tin Tài Khoản";

    $cuoi_href = "dangnhap.php";
    $cuoi_text = "Đăng Nhập";
    $cuoi_onclick = "";
} else if ($username == "admin") {
    $giohang_href = "quanlysp.php";
    $giohang_onclick = "";
    $giohang_text = "Quản lý Sản phẩm";

    $thongtin_href = "donhang.php";
    $thongtin_onclick = "";
    $thongtin_text = "Đơn Hàng";

    $cuoi_href = "dangxuat.php";
    $cuoi_text = "Đăng Xuất (" . htmlspecialchars($_SESSION['username']) . ")";
    $cuoi_onclick = "";
} else {
    $giohang_href = "giohang.php";
    $giohang_onclick = "";
    $giohang_text = "Giỏ Hàng";

    $thongtin_href = "thongtintaikhoan.php";
    $thongtin_onclick = "";
    $thongtin_text = "Thông Tin Tài Khoản";

    $cuoi_href = "dangxuat.php";
    $cuoi_text = "Đăng Xuất (" . htmlspecialchars($_SESSION['username']) . ")";
    $cuoi_onclick = "";
}
?>
<header class="flex justify-between items-center p-4 bg-secondary" style="background-color: #FDF5E6">
    <div class="text-2xl font-bold">NỘI THẤT TOÀN ĐẠT</div>
    <nav class="space-x-4">
        <a href="trangchu.php" class="text-muted hover:text-muted-foreground" style="color: black;">Trang Chủ</a>
        <a href="sanpham.php" class="text-muted hover:text-muted-foreground" style="color: black;">Sản Phẩm</a>
        <a href="<?= $giohang_href ?>" class="text-muted hover:text-muted-foreground" style="color: black;" <?= $giohang_onclick ? 'onclick="'.$giohang_onclick.'"' : '' ?>><?= $giohang_text ?></a>
        <a href="<?= $thongtin_href ?>" class="text-muted hover:text-muted-foreground" style="color: black;" <?= $thongtin_onclick ? 'onclick="'.$thongtin_onclick.'"' : '' ?>><?= $thongtin_text ?></a>
        <a href="<?= $cuoi_href ?>" class="text-muted hover:text-muted-foreground" style="color: black;" <?= $cuoi_onclick ? 'onclick="'.$cuoi_onclick.'"' : '' ?>><?= $cuoi_text ?></a>
    </nav>
    <input type="text" placeholder="Search..." class="border border-muted p-2 rounded" />
</header>
</head>