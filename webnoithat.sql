-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 08, 2025 lúc 05:51 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webnoithat`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `masp` varchar(10) NOT NULL,
  `tensp` varchar(500) NOT NULL,
  `gia` varchar(50) NOT NULL,
  `soluong` int(11) NOT NULL,
  `tentaikhoan` varchar(50) NOT NULL,
  `anh` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`masp`, `tensp`, `gia`, `soluong`, `tentaikhoan`, `anh`) VALUES
('sp02', 'Sofa đơn bọc nỉ (TS-SF11)', '6440000', 2, 'toan', 'https://i.pinimg.com/474x/8d/b4/c7/8db4c70715d523587e252ac0c318b27e.jpg'),
('sp01', 'Bàn làm việc chân sắt có hộc kéo (TS-VP39)', '3700000', 1, 'toan', 'https://i.pinimg.com/736x/79/a2/4f/79a24fa332c3db38b2ddddf0d08201c2.jpg'),
('sp03', 'Bàn IKEA 2m – Nhiều màu sắc (TS-VP32)', '3900000', 1, 'toan', 'https://i.pinimg.com/474x/b0/5b/8e/b05b8edb178e3e95ec9d351687941f3a.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `masp` varchar(10) NOT NULL,
  `tensp` longtext NOT NULL,
  `maloai` varchar(10) NOT NULL,
  `chatlieu` longtext NOT NULL,
  `mau` longtext NOT NULL,
  `hinhthuc` longtext NOT NULL,
  `mota` longtext NOT NULL,
  `gia` varchar(50) NOT NULL,
  `anh` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`masp`, `tensp`, `maloai`, `chatlieu`, `mau`, `hinhthuc`, `mota`, `gia`, `anh`) VALUES
('', 'INSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp01      \', N\'Bàn làm việc chân sắt có hộc kéo (TS-VP39)\', N\'ml01      \', N\'MDF chống ẩm phủ Melamine\r\n\r\nChân sắt sơn đen\', N\'nhiều màu, theo catalogue hãng ván\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Đây là chiếc bàn làm việc được THING thiết kế cho căn hộ của anh Vinh tại quận Ngũ Hành Sơn.\r\n\r\nLàm việc trên chiếc bàn này rất có cảm hứng nha.\r\n\r\nPhong cách minimalist tuyệt đẹp: Đường nét đơn giản, màu sắc hài hòa, mang lại cảm giác thanh lịch và hiện đại.\r\nChân bàn độc đáo: Thiết kế chân bàn kiểu chữ A bằng kim loại đen tạo nên sự vững chãi mà vẫn rất thanh thoát. Quá hợp cho những ai yêu thích phong cách industrial.\r\nMàu gỗ ấm áp: Tone màu nâu trầm của mặt bàn và kệ tạo cảm giác ấm cúng, thân thiện. Làm việc ở đây chắc chắn sẽ rất thoải mái và dễ chịu.\r\nKích thước rộng rãi: dài 1m6, sâu 0.6m, cao 0.75m\', N\'3,700,000\', N\'anh01.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp02      \', N\'Sofa đơn bọc nỉ (TS-SF11)\', N\'ml01      \', N\'Khung gỗ Dầu đã qua xử lí, chống mối mọt, cong vênh.\r\nChân sắt\r\nBọc vải nỉ\r\nNệm mút cứng có độ đàn hồi vừa phải\', N\'Tùy chọn theo bảng màu\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Khung gỗ Dầu đã qua xử lí, chống mối mọt, cong vênh\r\nChân sắt\r\nBọc vải nỉ\r\nNệm mút cứng có độ đàn hồi vừa phải\', N\'6,440,000\', N\'anh02.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp03      \', N\'Bàn IKEA 2m – Nhiều màu sắc (TS-VP32)\', NULL, N\'MDF chống ẩm phủ Melamine\r\nKhung sắt 25×50\', N\'full trắng, đen, xám, vân gỗ.\r\nHoặc kết hợp chúng với nhau.\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Bàn ikea 2m dành cho anh em nào có phòng làm việc rộng lớn.\r\n\r\nVới chiều dài 2m thì bỏ được cả thế giới lên. Thiết kế Bàn ikea 2m vô cùng đơn giản, thậm chí còn không có bất cứ một hoạ tiết nào quá nổi bật nhưng vẫn lôi cuốn ánh mắt của người nhìn. Chỉ là một “Tấm ván” vác ngang sang hai hộc tủ nhưng sự kết hợp này cùng màu sắc tạo nên vẻ đẹp thanh lịch, nhẹ nhàng.\r\n\r\n\', N\'3,900,000\', N\'anh3.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp04      \', N\'Bộ Bàn Ăn Scania (Màu Tự Nhiên, Mặt Vân Đá, 140)\', NULL, N\'Gỗ công nghiệp phủ Melamine vân đá tự nhiên\', N\'Lớp phủ Melamine có thể tái tạo chân thật vân đá tự nhiên mang lại vẻ đẹp sang trọng và hiện đại.\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Khung chân : Gỗ cao su tự nhiên\r\n\r\nBàn ăn gia đình làm từ chất liệu gỗ cao su tự nhiên đảm bảo độ chắc chắn cao, chống công vênh, mối mọt. Màu gỗ bắt mắt, đẹp tạo nét hiện đại .\r\n\r\nMặt bàn : Gỗ công nghiệp phủ Melamine vân đá tự nhiên \r\n\r\nLớp phủ Melamine có thể tái tạo chân thật vân đá tự nhiên mang lại vẻ đẹp sang trọng và hiện đại.\', N\'11,290,000\', N\'anh04.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp05      \', N\'Combo Giường Ngủ MOHO VLINE & Tủ Quần Áo MOHO VIENNA 1m5 Màu Gỗ Tự Nhiên\', NULL, N\'Gỗ MDF/ MFC phủ Melamin chuẩn CARB-P2 (*)\', N\'gỗ tràm tự nhiên\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Combo bao gồm: 1 giường & 1 set tủ 3 cánh 1m5 trong đó:\r\n\r\nCombo 1: Set tủ ngăn kệ màu tự nhiên\r\nCombo 2: Set tủ ngăn kệ màu gỗ phối trắng\r\nCombo 3: Set tủ thanh treo màu tự nhiên\r\nCombo 4: Set tủ thanh treo màu gỗ phối trắng\r\n+) 1 Giường ngủ 1m6 hoặc 1m8: Dài 212 x Rộng 176/196 x Cao đến đầu giường 92 (cm)\r\n\r\nChất liệu:\r\n\r\nSet tủ quần áo: Gỗ MDF/ MFC phủ Melamin chuẩn CARB-P2 (*)\r\n\r\nGiường ngủ: gỗ tràm tự nhiên, veneer sồi, gỗ cao su, plywood chuẩn CARB-P2 (*)\', N\'16,190,000\', N\'anh05.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp06      \', N\'NULCombo Phòng Khách MOHO VLINE Màu Tự NhiênL\', NULL, N\'Gỗ cao su tự nhiên - Gỗ thông tự nhiên\', N\'Màu Tự Nhiên\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Kích thước: \r\n\r\n- Sofa: Dài 180cm x Rộng 85cm x Cao 69cm\r\n\r\n- Sofa Góc: Rộng 140cm x Dài 60cm x Cao 69cm\r\n\r\n- Tủ Kệ TV:  Dài 160cm x Rộng 41cm x Cao 51cm\r\n\r\n- Bàn trà - Bàn cafe: Dài 100cm x  Rộng 50cm x Cao 40cm\r\n\r\nChất liệu:\r\n\r\n- Gỗ cao su tự nhiên - Gỗ thông tự nhiên\r\n\r\n- Vải sợi tổng hợp có khả năng chống thấm nước và dầu\r\n\r\n- Tấm phản: Gỗ công nghiệp Plywood chuẩn CARB-P2 (*) \r\n\r\n- Mây tre tự nhiên\', N\'17,890,000\', N\'anh06.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp07      \', N\'Tủ Quần Áo Gỗ Có Gương MOHO GRENAA 2 Nhiều Kích Thước\', NULL, N\'Gỗ MFC/MDF chuẩn CARB P2\', N\'Nâu\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Kích thước:\r\n\r\nTủ quần áo 1m2 2 cánh có gương: Dài 120 X Rộng 60 X Cao 200 (cm)\r\n\r\nSet Tủ quần áo 1m8 3 cánh gồm:\r\n\r\n1 Tủ ngăn kệ: Dài 60 X Rộng 60 X Cao 200 (cm)\r\n\r\n1 Tủ quần áo 2 cánh: Dài 120 X Rộng 60 X Cao 200 (cm)\r\n\r\nChất liệu chính: Gỗ MFC/MDF chuẩn CARB P2 (*)\', N\'5,299,000\', N\'anh07.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp08      \', N\'Combo Sofa Gỗ Cao Su Chữ L MOHO HOBRO ( Màu nâu, 2m7)\', NULL, N\'Gỗ cao su tự nhiên\', N\'nâu\', N\'Thi công lắp đặt tại nhà\r\n\', N\'Kích thước: \r\n\r\nSofa: Rộng 900 x Dài 1800 x Cao 700\r\n\r\nGhế góc: Rộng 900 x Dài 1600 x Cao 700\r\n\r\nChất liệu: \r\n\r\n- Gỗ cao su tự nhiên\r\n\r\n- Vải sợi tổng hợp chống nhăn, kháng bụi bẩn và nấm mốc\r\n\r\n- Tấm phản: Gỗ công nghiệp Plywood chuẩn CARB-P2 (*) \', N\'18,990,000\', N\'anh08.jpg\')\r\nINSERT INTO [dbo].[sanpham] ([masp], [tensp], [maloai], [chatlieu], [mau], [hinhthuc], [mota], [gia], [anh]) VALUES (N\'sp14      \', N\'Bộ Bàn Ăn Tròn Oslo (Màu Tự Nhiên, 100)\', NULL, N\'Gỗ cao su tự nhiên\', NULL, N\'lắp đặt tại nhà\', N\'Kích thước:\r\n\r\n- Bàn ăn: Đường kính 100cm x Chiều cao 75cm\r\n\r\n- Ghế ăn OSLO: Dài 50cm x Rộng 51cm x Cao 81cm \r\n\r\nChất liệu:\r\n\r\n- Mặt bàn: Gỗ cao su tự nhiên\r\n\r\n- Chân bàn: Gỗ cao su tự nhiên\r\n\r\n- Ghế ăn: Gỗ cao su tự nhiên , Vải bọc polyester chống nhăn, kháng bụi bẩn và nấm mốc\', N\'8,990,000\', N\'pro_combo_ban_an_4_ghe_noi_that_moho_combo___1__47aad841af2e42409077ab91379d589d_master.jpg\')\r\n', '', '', '', '', '', '', ''),
('', '', '', '', '', '', '', '', ''),
('sp01', 'Bàn làm việc chân sắt có hộc kéo (TS-VP39)', 'ml01', 'MDF chống ẩm phủ Melamine Chân sắt sơn đen', 'nhiều màu, theo catalogue hãng ván', 'Thi công lắp đặt tại nhà', 'Đây là chiếc bàn làm việc được THING thiết kế cho căn hộ của anh Vinh tại quận Ngũ Hành Sơn. Làm việc trên chiếc bàn này rất có cảm hứng nha. Phong cách minimalist tuyệt đẹp: Đường nét đơn giản, màu sắc hài hòa, mang lại cảm giác thanh lịch và hiện đại. Chân bàn độc đáo: Thiết kế chân bàn kiểu chữ A bằng kim loại đen tạo nên sự vững chãi mà vẫn rất thanh thoát. Quá hợp cho những ai yêu thích phong cách industrial. Màu gỗ ấm áp: Tone màu nâu trầm của mặt bàn và kệ tạo cảm giác ấm cúng, thân thiện. Làm việc ở đây chắc chắn sẽ rất thoải mái và dễ chịu. Kích thước rộng rãi: dài 1m6, sâu 0.6m, cao 0.75m', '3700000', 'https://i.pinimg.com/736x/79/a2/4f/79a24fa332c3db38b2ddddf0d08201c2.jpg'),
('', '', '', '', '', '', '', '', ''),
('sp02', 'Sofa đơn bọc nỉ (TS-SF11)', 'ml01', 'Khung gỗ Dầu đã qua xử lí, chống mối mọt, cong vênh. Chân sắt Bọc vải nỉ Nệm mút cứng có độ đàn hồi vừa phải', 'Tùy chọn theo bảng màu', 'Thi công lắp đặt tại nhà', 'Khung gỗ Dầu đã qua xử lí, chống mối mọt, cong vênh Chân sắt Bọc vải nỉ Nệm mút cứng có độ đàn hồi vừa phải', '6440000', 'https://i.pinimg.com/474x/8d/b4/c7/8db4c70715d523587e252ac0c318b27e.jpg'),
('', '', '', '', '', '', '', '', ''),
('', '', '', '', '', '', '', '', ''),
('', '', '', '', '', '', '', '', ''),
('sp03', 'Bàn IKEA 2m – Nhiều màu sắc (TS-VP32)', 'ml01', 'MDF chống ẩm phủ Melamine Khung sắt 25×50', 'full trắng, đen, xám, vân gỗ. Hoặc kết hợp chúng với nhau.', 'Thi công lắp đặt tại nhà', 'Bàn ikea 2m dành cho anh em nào có phòng làm việc rộng lớn. Với chiều dài 2m thì bỏ được cả thế giới lên. Thiết kế Bàn ikea 2m vô cùng đơn giản, thậm chí còn không có bất cứ một hoạ tiết nào quá nổi bật nhưng vẫn lôi cuốn ánh mắt của người nhìn. Chỉ là một “Tấm ván” vác ngang sang hai hộc tủ nhưng sự kết hợp này cùng màu sắc tạo nên vẻ đẹp thanh lịch, nhẹ nhàng.', '3900000', 'https://i.pinimg.com/474x/b0/5b/8e/b05b8edb178e3e95ec9d351687941f3a.jpg'),
('sp04', 'Bộ Bàn Ăn Scania (Màu Tự Nhiên, Mặt Vân Đá, 140)', 'ml01', 'Gỗ công nghiệp phủ Melamine vân đá tự nhiên', 'Lớp phủ Melamine có thể tái tạo chân thật vân đá tự nhiên mang lại vẻ đẹp sang trọng và hiện đại.', 'Thi công lắp đặt tại nhà', 'Khung chân : Gỗ cao su tự nhiên Bàn ăn gia đình làm từ chất liệu gỗ cao su tự nhiên đảm bảo độ chắc chắn cao, chống công vênh, mối mọt. Màu gỗ bắt mắt, đẹp tạo nét hiện đại . Mặt bàn : Gỗ công nghiệp phủ Melamine vân đá tự nhiên Lớp phủ Melamine có thể tái tạo chân thật vân đá tự nhiên mang lại vẻ đẹp sang trọng và hiện đại.', '11290000', 'https://i.pinimg.com/474x/12/78/e6/1278e6bd0c0a76ae66d1d5b9b8f4d04d.jpg'),
('sp05', 'Combo Giường Ngủ MOHO VLINE & Tủ Quần Áo MOHO VIENNA 1m5 Màu Gỗ Tự Nhiên', 'ml01', 'Gỗ MDF/ MFC phủ Melamin chuẩn CARB-P2 ()', 'gỗ tràm tự nhiên', 'Thi công lắp đặt tại nhà', 'Combo bao gồm: 1 giường & 1 set tủ 3 cánh 1m5 trong đó: Combo 1: Set tủ ngăn kệ màu tự nhiên Combo 2: Set tủ ngăn kệ màu gỗ phối trắng Combo 3: Set tủ thanh treo màu tự nhiên Combo 4: Set tủ thanh treo màu gỗ phối trắng +) 1 Giường ngủ 1m6 hoặc 1m8: Dài 212 x Rộng 176/196 x Cao đến đầu giường 92 (cm) Chất liệu: Set tủ quần áo: Gỗ MDF/ MFC phủ Melamin chuẩn CARB-P2 () Giường ngủ: gỗ tràm tự nhiên, veneer sồi, gỗ cao su, plywood chuẩn CARB-P2 (*)', '16190000', 'https://i.pinimg.com/736x/25/68/24/256824a0c3a8817c63d0d03e2e52666d.jpg'),
('sp06', 'NULCombo Phòng Khách MOHO VLINE Màu Tự NhiênL', 'ml01', 'Gỗ cao su tự nhiên - Gỗ thông tự nhiên', 'Màu Tự Nhiên', 'Thi công lắp đặt tại nhà', 'Kích thước: - Sofa: Dài 180cm x Rộng 85cm x Cao 69cm - Sofa Góc: Rộng 140cm x Dài 60cm x Cao 69cm - Tủ Kệ TV: Dài 160cm x Rộng 41cm x Cao 51cm - Bàn trà - Bàn cafe: Dài 100cm x Rộng 50cm x Cao 40cm Chất liệu: - Gỗ cao su tự nhiên - Gỗ thông tự nhiên - Vải sợi tổng hợp có khả năng chống thấm nước và dầu - Tấm phản: Gỗ công nghiệp Plywood chuẩn CARB-P2 (*) - Mây tre tự nhiên', '17890000', 'https://i.pinimg.com/736x/5b/e1/29/5be1290e264c30a7abedc1fb1f7fa40a.jpg'),
('sp07', 'Tủ Quần Áo Gỗ Có Gương MOHO GRENAA 2 Nhiều Kích Thước', 'ml01', 'Gỗ MFC/MDF chuẩn CARB P2', 'Nâu', 'Thi công lắp đặt tại nhà', 'Kích thước: Tủ quần áo 1m2 2 cánh có gương: Dài 120 X Rộng 60 X Cao 200 (cm) Set Tủ quần áo 1m8 3 cánh gồm: 1 Tủ ngăn kệ: Dài 60 X Rộng 60 X Cao 200 (cm) 1 Tủ quần áo 2 cánh: Dài 120 X Rộng 60 X Cao 200 (cm) Chất liệu chính: Gỗ MFC/MDF chuẩn CARB P2 (*)', '5299000', 'https://i.pinimg.com/736x/aa/8b/65/aa8b655af2b0684b33ffa589fdfbffde.jpg'),
('sp08', 'Combo Sofa Gỗ Cao Su Chữ L MOHO HOBRO ( Màu nâu, 2m7)', 'ml01', 'Gỗ cao su tự nhiên', 'nâu', 'Thi công lắp đặt tại nhà', 'Kích thước: Sofa: Rộng 900 x Dài 1800 x Cao 700 Ghế góc: Rộng 900 x Dài 1600 x Cao 700 Chất liệu: - Gỗ cao su tự nhiên - Vải sợi tổng hợp chống nhăn, kháng bụi bẩn và nấm mốc - Tấm phản: Gỗ công nghiệp Plywood chuẩn CARB-P2 (*) ', '18990000', 'https://i.pinimg.com/736x/53/28/ad/5328ad2cfa093ca802e5256cafd5ccd6.jpg'),
('sp14', 'Bộ Bàn Ăn Tròn Oslo (Màu Tự Nhiên, 100)', 'ml01', 'Gỗ cao su tự nhiên', 'NÂU', 'lắp đặt tại nhà', 'Kích thước: - Bàn ăn: Đường kính 100cm x Chiều cao 75cm - Ghế ăn OSLO: Dài 50cm x Rộng 51cm x Cao 81cm Chất liệu: - Mặt bàn: Gỗ cao su tự nhiên - Chân bàn: Gỗ cao su tự nhiên - Ghế ăn: Gỗ cao su tự nhiên , Vải bọc polyester chống nhăn, kháng bụi bẩn và nấm mốc', '8990000', 'pro_combo_ban_an_4_ghe_noi_that_moho_combo___1__47aad841af2e42409077ab91379d589d_master.jpg'),
('', '', '', '', '', '', '', '', ''),
('', '', '', '', '', '', '', '', ''),
('', '', '', '', '', '', '', '', ''),
('', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `taikhoan` varchar(100) NOT NULL,
  `matkhau` varchar(10) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `sdt` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`taikhoan`, `matkhau`, `diachi`, `sdt`) VALUES
('admin', '0123456789', '20 phan chu trinh', 123456789),
('toan', '0123456789', '20 phan chu trinh', 334604948),
('toan2', '123', 'ádfasdf', 654645);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
