<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GocDienAnhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('goc_dien_anhs')->truncate();

        DB::table('goc_dien_anhs')->insert([
            [
                'tieu_de' => 'Nhiều đánh giá tích cực về The Flash 2023 từ các nhà phê bình phim',
                'noi_dung' => 'Bộ phim "The Flash" năm 2023 nhận được nhiều đánh giá tích cực từ các nhà phê bình phim trên toàn thế giới. Bobby LePire từ Film Threat cho rằng The Flash 2023 là một bộ phim tuyệt vời, với sự phô diễn ấn tượng của sức mạnh tốc độ siêu nhanh. Những kỹ xảo đặc biệt và thiết kế hình ảnh tuyệt vời đã giúp phim trở thành một trải nghiệm thị giác đáng nhớ. Tổng thể, các đánh giá đều tích cực và đánh giá cao sự nỗ lực của đội ngũ làm phim. Phim hứa hẹn sẽ mang đến cho khán giả những phút giây giải trí đầy kịch tính và nhịp điệu nhanh, cùng với những cảm xúc sâu sắc và tình tiết bất ngờ. Cùng đón chờ phim ra rạp ngày 16/06.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2023/06/flash-2023-Large.jpeg',
                'ngay_dang' => '2023-06-15',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => '5 bộ phim Cowboy kinh điển được yêu thích nhất mọi thời đại',
                'noi_dung' => 'Trong bài viết này, Góc Điện Ảnh giới thiệu đến bạn 5 bộ phim về cowboy hay nhất mọi thời đại, từ những tác phẩm kinh điển được yêu thích đến các bộ phim mới nhất. Hãy cùng khám phá và tìm hiểu thế giới của những tay súng miền Tây nào!',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2023/04/phim-Birdman-5.jpg',
                'ngay_dang' => '2023-04-29',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review phim Dungeons & Dragons (Ngục tối và Rồng)',
                'noi_dung' => 'Đã rất lâu rồi mới có một bộ phim điện ảnh chuyển thể từ game nhận được đánh giá tốt như vậy. Trước hết, bạn cần biết Trò chơi Dungeon & Dragon là gì? Dungeon & Dragon bắt nguồn là một board game (Trò chơi sử dụng bàn cờ). Chúng ta quen thuộc với các board game như Cờ Vua, Cờ Tướng, UNO, Ma Sói, Cờ Tỉ Phú, … Nhưng thể loại boardgame nhập vai như Dungeon & Dragon thì khá ít người biết.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2023/04/review-phim-nguc-toi-va-rong-2.webp',
                'ngay_dang' => '2023-03-15',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review phim Everything Everywhere All At Once – Phiền muộn của bạn chỉ là cái bánh Bagel thôi',
                'noi_dung' => 'Everything Everywhere All at Once cố tình để khuyết thiếu một câu trả lời dứt khoát cho nỗi băn khoăn về một kiếp sống vô nghĩa giữa những vũ trụ bao la, không hồi kết. Một thế hệ mong đợi một cuộc đời bớt đi áp lực dồn nặng trên vai, một cuộc đời tự do khỏi bàn tay vận mệnh, y như lời bài hát vào cuối phim bởi Son Lux, Mitski và David Byrne: “This is a life / Free from destiny / Not only what we sow / Not only what we show.” Ai mà chẳng hy vọng một cuộc đời mà độ nghiêm trọng của mọi lo âu phiền muộn đều chỉ như cái bánh bagel?',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2022/06/everything-everywhere-all-at-once-2.jpg',
                'ngay_dang' => '2023-02-20',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review phim The French Dispatch lối kể chuyện mới của Wes Anderson',
                'noi_dung' => 'Bộ phim kể những câu chuyện diễn ra ở Pháp qua ống kính của các phóng viên ngoại quốc. Bằng cách dịch các câu chuyện từ trang báo sang định dạng điện ảnh, đạo diễn Wes Anderson thể hiện khả năng kể chuyện bằng hình ảnh một cách sáng tạo, hài hước và rất mượt mà. The French Dispatch có sự ảnh hưởng rất nhiều từ Làn sóng điện ảnh mới của Pháp, phim hài kịch những năm 30 và văn hóa đại chúng những năm 60.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2021/12/review-the-french-dispatch.jpg',
                'ngay_dang' => '2023-01-10',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review và giải thích phim Power Of The Dog – Màn trả thù đầy bất ngờ',
                'noi_dung' => 'Tiêu đề “Power Of The Dog” được lấy cảm hứng từ Kinh thánh trong đoạn mô tả khi Chúa Giê-su đang chịu đau khổ trên thập tự giá. Nội dung như sau “Deliver me from the sword, my precious life from the power of the dogs”. Đặc biệt, yếu tố tâm lý trong phim rất nặng đô, những hành động, vẻ mặt tưởng chừng vô cùng đơn giản nhưng cũng luôn chứa đầy hàm ý.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2021/12/review-phim-the-power-of-the-dog-3.jpg',
                'ngay_dang' => '2022-12-05',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review phim Free Guy đậm chất hài hước của Ryan Reynolds',
                'noi_dung' => 'Đánh giá phim Free Guy là một tác phẩm hài hành động thú vị. Một phim đậm chất giải trí với những màn tấu hài khiến người xem phải cười nghiêng ngã, những pha hành động đẹp mắt và thông điệp nhẹ nhàng. Nhạc phim góp phần lớn vào việc đẩy cảm xúc người xem xuyên suốt phim.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2021/09/review-phim-free-guy-1.jpg',
                'ngay_dang' => '2022-11-20',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review phim Birdman - Con đường tìm kiếm giá trị của cuộc đời và nghệ thuật',
                'noi_dung' => 'Birdman là một kiệt tác điện ảnh và đã khẳng định vị trí của đạo diễn Alejandro G. Inarritu trong làng điện ảnh thế giới. Nội dung phim Birdman kể về Riggan Thomson (Do Michael Keaton thủ vai), một ngôi sao hết thời, quyết định tái xuất sân khấu Broadway để tái lập danh tiếng của mình. Trong quá trình chuẩn bị cho vở kịch, Riggan phải đối mặt với những thử thách khó khăn như những nhân vật khó tính trên sân khấu, những rắc rối gia đình và một con quỷ trong đầu của ông.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2023/04/phim-Birdman-2.jpeg',
                'ngay_dang' => '2022-10-15',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review phim Spotlight (2015) - Góc nhìn chân thực về nạn lạm dụng tình dục',
                'noi_dung' => 'Phim Spotlight dựa trên câu chuyện có thật về cuộc điều tra của nhóm Spotlight, một nhóm nhà báo tại tờ Boston Globe, liên quan đến nạn lạm dụng tình dục của giáo sĩ đối với trẻ em trong Giáo hội Công giáo Rôma ở Boston. Phim tạo ấn tượng sâu sắc cho người xem và được các nhà phê bình đánh giá rất cao. Phim đạt điểm đánh giá 8.1 trên IMDb và 97% tươi trên Rotten Tomatoes.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2023/03/review-phim-spotlight-3.jpg',
                'ngay_dang' => '2022-09-10',
                'trang_thai' => 1,
            ],
            [
                'tieu_de' => 'Review phim D.P (Truy bắt lính đào ngũ) series ăn khách trên Netflix',
                'noi_dung' => 'D.P là từ viết tắt của Deserter Pursuit (Truy bắt lính đào ngũ). Phim D.P đang tạo được sự chú ý trên Netflix vì phản ánh mặt trái của chế độ quân ngũ bắt buộc ở xứ sở Kim Chi. D.P lột tả về cuộc sống của đội quân cảnh chuyên bắt những người lính đào ngũ.',
                'hinh_anh' => 'https://www.gocdienanh.com/wp-content/uploads/2021/09/review-phim-dp-truy-bat-linh-dao-ngu-4.jpg',
                'ngay_dang' => '2022-08-05',
                'trang_thai' => 1,
            ],
        ]);
    }
}
