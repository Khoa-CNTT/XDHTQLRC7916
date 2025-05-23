<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuKienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('su_kiens')->delete();
        DB::table('su_kiens')->truncate();
        $now = Carbon::now();
        $endDate = $now->copy()->addDays(30);
        DB::table('su_kiens')->insert([
            [
                'ten_su_kien' => 'THÔNG BÁO QUYỀN LỢI THÀNH VIÊN 2025',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => '- Hạng VIP (Khách hàng có chi tiêu từ 2,000,000 VND đến 4,999,999 VND trong năm 2024):

   + 04 Vé xem phim 2D

   + 01 Harmony Single Combo (01 bắp rang + 01 nước ngọt)

   + 01 Harmony Couple Combo (01 bắp rang + 02 nước ngọt)

- Hạng Platinum (Khách hàng có chi tiêu từ 5,000,000 VND trở lên trong năm 2024):

   + 10 Vé xem phim 2D

   + 02 Harmony Single Combo (01 bắp rang + 01 nước ngọt)

   + 02 Harmony Couple Combo (01 bắp rang + 02 nước ngọt)

   + 01 Quà tặng đặc biệt (Dự kiến sẽ công bố tháng 6.2025)',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/c8c7ba6341fa493384d6eea221911b78.jpg',
            ],
            [
                'ten_su_kien' => 'BÁNH MÌ QUE NÓNG GIÒN',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Ngon giòn nóng hổi từ lớp vỏ.... đầy đặn đẫm xốt trong lớp nhân, bánh mì que đã sẵn sàng phục vụ quý khách với 03 hương vị:

**Xúc xích phô mai ** Pate chà bông ** Gà phô mai**

Sản phẩm có bán lẻ hoặc theo combo bắp nước đi kèm:

- Giá lẻ: 50k/que

- Giá Combo:

Combo 140k = 1 bánh mì que + 1 bắp + 1 nước

Combo 199k=  2 bánh mì que + 1 bắp + 2 nước

Sản phẩm hiện đang có mặt tại:

- TP.HCM: Nam Sài Gòn, Gò Vấp, Cộng Hòa, Cantavil, Nowzone, Thủ Đức, Moonlight, Goldview,Phú Thọ.

- Hà Nội: WestLake, Hà Đông, Kosmo, Thăng Long.

- Khác: Đồng Nai, Biên Hòa, Bình Dương, Dĩ An, Vũng Tàu, Tây Ninh, Long Xuyên, Ninh Kiều, Cái Răng, Nha Trang Thái Nguyên, Nha Trang Trần Phú, Phan Thiết, Đà Nẵng, Phan Rang, Hội An, Đồng Hới, Bảo Lộc, Cà Mau, Huế',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/81580cbcf15644faa4f678ff0593fd1e.jpg',
            ],
            [
                'ten_su_kien' => 'SUPERPLEX - CÔNG NGHỆ MỚI VƯỢT TRỘI & ĐẲNG CẤP',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Xuất hiện lần đầu tiên tại Việt Nam, công nghệ chiếu phim mới SUPERPLEX sở hữu nhiều ưu điểm nổi trội so với phòng chiếu tiêu chuẩn:

- Màn hình cong cực đại với kích thước cực lớn 24.6 x 11.2m;

- Máy chiếu laser siêu sáng (56,000 Lumens), nguồn sáng laser cho màu sắc rực rỡ, đồng nhất và ổn định trong suốt 30,000 giờ, độ tương phản 2500:1 cao hơn 25% so với máy chiếu thông thường đem đến từng khung hình rõ nét, chân thật;

- Có khả năng phát phim 3D ở độ phân giải 4K (4098 x 2160) và phim 2D 4K với tốc độ khung hình lên đến 60fps;

- Hệ thống âm thanh Dolby Atmos, đem tới sự tận hưởng điện ảnh tuyệt vời nhất như chính bạn ở trong phim;

- Phòng chiếu và sảnh chờ sang trọng, đẳng cấp, không gian phòng chiếu với 512 ghế ngồi, khoảng cách các hàng ghế rộng, độ dốc thoải mái, êm ái vô cùng với ghế đôi, ghế Prestige, ghế VIP dành cho mọi đối tượng khán giả, không chỉ tận hưởng bộ phim tuyệt vời còn phù hợp tổ chức các sự kiện, fan meeting…

*Địa chỉ:

Phòng chiếu SUPERPLEX
Phòng chiếu số 7, Cụm rạp Lotte Cinema Gò Vấp
Lotte Mart, 242 Nguyễn Văn Lượng, Phường 10, Gò Vấp, TP.HCM',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/9f133beb31a743b3847f219689a53da9.jpg',
            ],
            [
                'ten_su_kien' => 'PHÒNG CHIẾU CINECOMFORT - LẠC VÀO THẾ GIỚI ĐIỆN ẢNH TRÊN GHẾ SOFA CAO CẤP',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Nằm trong hệ thống phòng chiếu cao cấp của LOTTE Cinema Việt Nam, CineComfort mang đến trải nghiệm điện ảnh khác biệt nhằm hướng đến sự thoải mái của khách hàng:

⭐ Trang bị Ghế Recliner - Ghế da sang trọng, mềm mại, có thể điều chỉnh độ ngả của ghế cho tư thế thoải mãi nhất.

⭐ Hoàn thiện trải nghiệm với màn hình sắc nét và âm thanh sống động

Hãy mau ra rạp trải nghiệm phòng chiêu cao cấp này cùng người thân & bạn bè nhé!!!',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/2d59c4b81f5b42119d1886e9c56204b0.jpg',
            ],
            [
                'ten_su_kien' => 'PHÒNG CHIẾU CHARLOTTE - THƯỞNG THỨC ĐIỆN ẢNH VỚI PHONG CÁCH SANG TRỌNG và ĐẦY TÍNH RIÊNG BIỆTƯu đãi vé xem phim 5.000đ qua VinID',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Nằm trong hệ thống phòng chiếu cao cấp của LOTTE Cinema Việt Nam, CharLotte thuộc phân khúc sang trọng bậc nhất với trải nghiệm điện ảnh hạng “thương gia” cho khách hàng.

⭐Ghế ngồi đẳng cấp, sang trọng và dễ dàng điều chỉnh độ ngả theo ý muốn.

⭐Welcome Set – Phần ăn nhẹ miễn phí tại khu vực phòng chờ riêng dành cho khách xem phòng CharLotte.

⭐Trang bị màn hình sắc nét, âm thanh sống động và dịch vụ hỗ trợ ngay tại chỗ chỉ với 01 nút bấm.

⭐Các dịch vụ đi kèm: Sử dụng Tủ chăm sóc giày thông minh, chăn ấm và menu đặc biệt của CharLotte.

 Hãy mau ra rạp trải nghiệm phòng chiêu cao cấp này cùng người thân & bạn bè nhé!!!',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/0d739e0fdff546cf9e658c23653c8670.jpg',
            ],
            [
                'ten_su_kien' => 'LY PHIM MỚI: LẬT MẶT 8 – VÒNG TAY NẮNG',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Chỉ có tại lotte Cinema, thiết kế đặc biệt dành riêng cho Lật Mặt 8 với dung tích ~750ml. Sở hữu ngay trục tiếp tại quầy !!!

COMBO A = 01 ly LẬT MẶT 8

*Giá 169K cho nhóm rạp 1 * Giá 159K cho nhóm rạp 2

COMBO B = 01 ly LẬT MẶT 8 + 01 nước ngọt + 01 bắp lớn

*Giá 199K cho nhóm rạp 1 * Giá 189K cho nhóm rạp 2

COMBO C = 01 ly LẬT MẶT 8 + 02 nước ngọt + 01 bắp lớn

*Giá 219K cho nhóm rạp 1 * Giá 209K cho nhóm rạp 2',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/a9d22613867f485db2f9023115199ecf.jpg',
            ],
            [
                'ten_su_kien' => 'MUA COMBO – NHẬN QUÀ CỰC ĐÃ',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Từ 28.04 đến 04.05, khi mua combo bất kỳ có đồ uống của Pepsico, bạn sẽ nhận ngay 1 trong các quà tặng hấp dẫn:

 Pepsi Black / Mirinda hoặc... Bộ gõ mõ "tịnh tâm" siêu chill~

* Áp dụng tại: Gò Vấp, Biên Hòa, Đồng Nai, Vũng Tàu, Nha Trang, Thái Nguyên-Trần Phú, Hạ Long, Huế, Bắc Giang',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/0c16b826b3534bc5a4ef4fdf768c177c.jpg',
            ],
            [
                'ten_su_kien' => 'ĐẶT VÉ XEM PHIM LOTTE 79K TRÊN ỨNG DỤNG NGÂN HÀNG VÀ VÍ VNPAY',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Chỉ từ 79K cho vé xem phim rạp LOTTE
Đặt vé xem phim ngay trên Ví VNPAY & hầu hết các ứng dụng ngân hàng Agribank, Vietcombank, BIDV, VietinBank...',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/fe85760122524f44be62bda6f814edcf.jpg',
            ],
            [
                'ten_su_kien' => 'DIỆN ĐỒ CHẤT VIỆT - NHẬN QUÀ CỰC CHẤT',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Chương trình đặc biệt khi khách đến xem phim tại Lotte Cinema trong TTTM GO!

Chi tiết: Mặc Việt Phục đến 06 rạp Lotte Cinema trong Go! và check-in trên Facebook cá nhân hoặc Google Map để về tay 1 trong 2 𝐁𝐚̆́𝐩 𝐇𝐚𝐫𝐦𝐨𝐧𝐲 (𝟐 𝐯𝐢̣) 𝐡𝐨𝐚̣̆𝐜 𝐥𝐲 𝐩𝐡𝐢𝐦 đ𝐨̣̂𝐜 𝐪𝐮𝐲𝐞̂̀𝐧

* Thời gian diễn ra từ 21 đến hết ngày 04.05.2025

* Địa điểm: Lotte Cinema Thăng Long, Bắc Giang, Ninh Bình, Hạ Long, Huế và Cần Thơ',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/738980c004534da58c9dc6c3aebb0c57.jpg',
            ],
            [
                'ten_su_kien' => 'Nhập mã MMLOTTE: Giảm liền 10K khi đặt vé LOTTE Cinema',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Nhanh tay nhập code “MMLOTTE” để được giảm 10.000đ (cho hóa đơn từ 200.000đ) khi mua vé phim hoặc combo bắp nước tại LOTTE Cinema

Đặc biệt, code “MMLOTTE” sẽ khả dụng đến hết tháng 05.2025

Tranh thủ xài liền kẻo hết nhaaaaaaaaaa',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/3467a31107cb406a9d27f2c225e770cf.jpg',
            ],
            [
                'ten_su_kien' => 'Triển lãm "The Mute"',
                'ngay_bat_dau' => $now,
                'ngay_ket_thuc' => $endDate,
                'tinh_trang' => 1,
                'mo_ta' => 'Triển lãm sơn mài truyền thống của họa sĩ Nguyễn Tuấn Cường tại Art 30 Gallery.',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/5e27ab8899d74fadb82aa6eb68294483.png',
            ],
        ]);
    }
}
