<?php include"head.php" ?>
<?php


// Database connection
$server = 'localhost';
$user = 'root';
$pass = '';
$database = 'webnoithat';

$conn = new mysqli($server, $user, $pass, $database);
$conn->set_charset("utf8");

// Check login status
$tentaikhoan = isset($_SESSION['username']) ? $_SESSION['username'] : '';
if (empty($tentaikhoan)) {
    echo "<script>alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location='login.php';</script>";
    exit;
}

// Handle delete item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_masp'])) {
    $masp = $_POST['delete_masp'];
    $query = "DELETE FROM giohang WHERE masp = ? AND tentaikhoan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $masp, $tentaikhoan);
    if ($stmt->execute()) {
        echo "<script>alert('Xóa sản phẩm thành công!');</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['thanh_toan'])) {
    $query = "SELECT masp, tensp, gia, soluong, anh FROM giohang WHERE tentaikhoan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tentaikhoan);
    $stmt->execute();
    $result = $stmt->get_result();
    $tongtien = 0;

    while ($row = $result->fetch_assoc()) {
        $masp = $row['masp'];
        $tensp = $row['tensp'] ?? 'Không có tên';
        $anh = $row['anh'] ?? '';
        $gia = floatval(preg_replace("/[^0-9.-]/", "", $row['gia']));
        $soluong = intval($row['soluong'] ?? 1);
        $thanhTien = $gia * $soluong;
        $tongtien += $thanhTien;

        // Insert into donhang
        $insert_query = "INSERT INTO donhang (tentaikhoan, masp, tensp, tongtien, soluong) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("sssdi", $tentaikhoan, $masp, $tensp, $thanhTien, $soluong);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    // Clear cart after checkout
    $delete_query = "DELETE FROM giohang WHERE tentaikhoan = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("s", $tentaikhoan);
    $delete_stmt->execute();
    $delete_stmt->close();

    echo "<script>alert('Thanh toán thành công! Tổng tiền: " . number_format($tongtien, 0, ',', '.') . " VNĐ'); window.location='cart.php';</script>";
    $stmt->close();
}

// Load cart items
$query = "SELECT masp, tensp, gia, soluong, anh FROM giohang WHERE tentaikhoan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $tentaikhoan);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Nội Thất Toàn Đạt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .giohang-wrapper {
            background-color: #e5e0d8;
            min-height: 100vh;
            padding: 16px;
        }

        .cart-container {
            background-color: #fffefc;
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            display: grid;
            grid-template-columns: 1fr 4fr 2fr 2fr 2fr 1fr;
            text-align: center;
            font-weight: 600;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 12px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 1fr 4fr 2fr 2fr 2fr 1fr;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #d1d5db;
            gap: 8px;
        }

        .cart-item img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 6px;
            transition: opacity 0.3s ease;
        }

        .cart-item img[loading="lazy"] {
            opacity: 0;
        }

        .cart-item img.loaded {
            opacity: 1;
        }

        .cart-item .form-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
        }

        .cart-item .product-name {
            font-size: 14px;
            font-weight: 500;
        }

        .cart-item .gia {
            text-align: center;
        }

        .cart-item .quantity-input {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 4px 8px;
            width: 80px;
            text-align: center;
        }

        .cart-item .thanh-tien {
            text-align: right;
            padding-right: 8px;
        }

        .cart-item .delete-btn {
            background-color: #cd853f;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 4px 12px;
            font-size: 14px;
            cursor: pointer;
        }

        .cart-item .delete-btn:hover {
            opacity: 0.9;
        }

        .total-section {
            margin-top: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .total-section .total-text {
            font-size: 18px;
            font-weight: 600;
            text-align: right;
        }

        .total-section .total-text span {
            color: #dc2626;
        }

        .total-section .checkout-btn {
            background-color: #cd853f;
            color: white;
            font-weight: 600;
            padding: 8px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }

        .total-section .checkout-btn:hover {
            opacity: 0.9;
        }

        @media (min-width: 640px) {
            .total-section {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
            .total-section .checkout-btn {
                width: auto;
            }
        }

        @media (max-width: 768px) {
            .cart-header, .cart-item {
                grid-template-columns: 1fr 3fr 2fr 2fr 2fr 1fr;
            }
            .cart-item img {
                width: 48px;
                height: 48px;
            }
            .cart-item .quantity-input {
                width: 60px;
            }
        }
    </style>
    <script>
        // Update subtotal when quantity changes
        function updateThanhTien(input) {
            var row = input.closest('.cart-item');
            var giaStr = row.querySelector('.gia').getAttribute('data-gia') || "0";
            var gia = parseFloat(giaStr.replace(/[^0-9.-]+/g, "")) || 0;
            var soluong = parseInt(input.value) || 1;
            if (soluong < 1) {
                input.value = 1;
                soluong = 1;
            }
            var thanhTienElement = row.querySelector('.thanh-tien');
            var thanhTien = gia * soluong;
            thanhTienElement.textContent = thanhTien.toLocaleString('vi-VN') + ' VNĐ';
            updateTongTien();
        }

        // Update total when checkbox or quantity changes
        function updateTongTien() {
            var tongTien = 0;
            var checkedBoxes = document.querySelectorAll('.form-checkbox:checked');
            checkedBoxes.forEach(function (checkbox) {
                var row = checkbox.closest('.cart-item');
                var thanhTienStr = row.querySelector('.thanh-tien').textContent.replace(/[^\d]/g, "");
                var thanhTien = parseFloat(thanhTienStr) || 0;
                tongTien += thanhTien;
            });
            document.getElementById('lblTongTien').textContent = tongTien.toLocaleString('vi-VN') + ' VNĐ';
        }

        // Attach events on page load
        document.addEventListener('DOMContentLoaded', function () {
            var checkboxes = document.querySelectorAll('.form-checkbox');
            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', updateTongTien);
            });
            updateTongTien(); // Initialize total
            // Handle image loading
            var images = document.querySelectorAll('.cart-item img');
            images.forEach(function (img) {
                if (img.complete) {
                    img.classList.add('loaded');
                } else {
                    img.addEventListener('load', function () {
                        img.classList.add('loaded');
                    });
                    img.addEventListener('error', function () {
                        img.src = 'anh/fallback.jpg';
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="giohang-wrapper p-4 min-h-screen">
        <div class="cart-container">
            <div class="cart-header">
                <div>CHỌN</div>
                <div>SẢN PHẨM</div>
                <div>GIÁ</div>
                <div>SỐ LƯỢNG</div>
                <div>THÀNH TIỀN</div>
                <div>XÓA</div>
            </div>

            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <div class="text-center">
                        <input type="checkbox" class="form-checkbox" onchange="updateTongTien()" />
                    </div>
                    <div class="flex items-center gap-2">
                        <?php
                        $anh = $item['anh'] ?? '';
                        if (empty($anh)) {
                            $imgSrc = 'images/fallback.jpg'; // hoặc 'anh/fallback.jpg' nếu bạn để fallback ở đó
                        } elseif (preg_match('/^https?:\\/\\//i', $anh)) {
                            $imgSrc = $anh;
                        } else {
                            $imgSrc = 'anh/' . $anh;
                        }
                        ?>
                        <img 
                            src="<?= htmlspecialchars($imgSrc) ?>" 
                            alt="<?= htmlspecialchars($item['tensp'] ?? 'Product Image') ?>" 
                            loading="lazy" 
                            class="rounded-md w-16 h-16 object-cover"
                            onerror="this.onerror=null;this.src='images/fallback.jpg';"
                        />
                        <span class="product-name"><?php echo htmlspecialchars($item['tensp'] ?? 'Không có tên'); ?></span>
                    </div>
                    <div class="gia text-center" data-gia="<?php echo htmlspecialchars($item['gia'] ?? '0'); ?>">
                        <?php echo htmlspecialchars(number_format(floatval($item['gia'] ?? 0), 0, ',', '.') . ' VNĐ'); ?>
                    </div>
                    <div class="text-center">
                        <input type="number" class="quantity-input" value="<?php echo htmlspecialchars($item['soluong'] ?? '1'); ?>" min="1" oninput="updateThanhTien(this)" />
                    </div>
                    <div class="thanh-tien text-right pr-2">
                        <?php
                        $gia = floatval(preg_replace("/[^0-9.-]/", "", $item['gia'] ?? 0));
                        $soluong = intval($item['soluong'] ?? 1);
                        echo number_format($gia * $soluong, 0, ',', '.') . ' VNĐ';
                        ?>
                    </div>
                    <div class="text-center">
                        <form method="post">
                            <input type="hidden" name="delete_masp" value="<?php echo htmlspecialchars($item['masp']); ?>" />
                            <button type="submit" class="delete-btn">XÓA</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="total-section">
                <div class="total-text">
                    TỔNG TIỀN: <span id="lblTongTien">0 VNĐ</span>
                </div>
                <form method="post">
                    <button type="submit" name="thanh_toan" class="checkout-btn">THANH TOÁN</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>