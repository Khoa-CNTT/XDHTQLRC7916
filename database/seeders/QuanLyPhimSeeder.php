<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuanLyPhimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quan_ly_phims')->delete();
        DB::table('quan_ly_phims')->insert([
            [
                'ten_phim'         => 'Bộ tứ báo thủ',
                'slug_phim'        => 'bo-tu-bao-thu',
                'ngay_chieu'       => Carbon::parse('2025-01-29'),
                'thoi_luong'       => '133',
                'dao_dien'         => 'Trấn Thành',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745075677/botubaothu_hdpm7g.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/zKMOgOWn8lQ?si=Z9vaeQU9zvxcSIHy',
                'dien_vien'        => 'Tran Thành, Le Duong Bao Lam, Le Giang, Uyen An, Quoc Anh, Tieu Vi, Ky Duyen',
                'nha_san_xuat'     => '3388 Films',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '13+',
                'mo_ta'            => 'Bộ tứ báo thủ xoay quanh mối tình tay ba đầy trớ trêu nhưng cũng lắm chiêu trò giữa ba nhân vật chính.',
                'danh_gia'         => '9.5/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim'         => 'Nụ hôn bạc tỷ',
                'slug_phim'        => 'nu-hon-bac-ty',
                'ngay_chieu'       => Carbon::parse('2025-01-29'),
                'thoi_luong'       => '100',
                'dao_dien'         => 'Thu Trang',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745075897/nuhonbacti_vubymb.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/T6H8dxaoyI8?si=Z9vaeQU9zvxcSIHy',
                'dien_vien'        => 'Thu Trang, Đoàn Thiên Ân, Lê Xuân Tiền, Ma Ran Đô, Tiến Luật',
                'nha_san_xuat'     => 'Thu Trang',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '16+',
                'mo_ta'            => 'Vân – cô gái bán bánh mì – vô tình gặp hai chàng trai trong một tai nạn, tạo nên mối tình tay ba đầy kịch tính và hài hước.',
                'danh_gia'         => '9.3/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim'         => 'Yêu nhầm bạn thân',
                'slug_phim'        => 'yeu-nham-ban-than',
                'ngay_chieu'       => Carbon::parse('2025-01-29'),
                'thoi_luong'       => '106',
                'dao_dien'         => 'Nguyễn Quang Dũng, Diệp Thế Vinh',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745076010/yeunhambanthan_oi4lzk.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/Z7AbUpnfcW8?si=GXcIQOuNXxq7XC-q',
                'dien_vien'        => 'Kaity Nguyễn, Trần Ngọc Vàng, Thanh Sơn',
                'nha_san_xuat'     => 'HK Film, Galaxy Studio',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '16+',
                'mo_ta'            => 'Bình An – cô gái đang hạnh phúc với bạn trai – bỗng rơi vào tình thế “friend zone” với người bạn thân Toàn, tạo nên chuỗi tình huống dở khóc dở cười.',
                'danh_gia'         => '8.5/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim'         => 'Gấu Yêu Của Anh',
                'slug_phim'        => 'gau-yeu-cua-anh',
                'ngay_chieu'       => Carbon::parse('2025-04-04'),
                'thoi_luong'       => '119',
                'dao_dien'         => 'Ping Lumpraploeng',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745077515/470x700-muaythai_path0j.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/VQOOUxTah0w?si=SQ2DAWz5M6H4dwEz',
                'dien_vien'        => 'Jirayu La‑ongmani, Sananthachat Thanapatpisal, Chinawut Indracusin, Supathat Opas, Auttawut Inthong',
                'nha_san_xuat'     => '',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '16+',
                'mo_ta'            => 'San mơ trở lại với sự nghiệp, bất ngờ “trượt chân” vào lưới tình với Momo, khiến bao tình huống dở khóc dở cười xảy ra.',
                'danh_gia'         => '7.8/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim'         => 'Cưới Ma Giải Hạn',
                'slug_phim'        => 'cuoi-ma-giai-han',
                'ngay_chieu'       => Carbon::parse('2025-04-11'),
                'thoi_luong'       => '128',
                'dao_dien'         => 'Chayanop Bunprakob',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745076369/cuumagiaihan_mcd5pi.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/a0XdUK9Onvc?si=KcpZeecpSCYNnL7m',
                'dien_vien'        => 'Putthipong Assaratanakul, Krit Amnuaydechkorn, Goy Arachaporn Pokinpakorn, Piyamas Monayakul, Jaturong Mokjok',
                'nha_san_xuat'     => 'Weerachai Yaikwawong, Banjong Pisanthanakun',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '18+',
                'mo_ta'            => 'Menn – chàng trai thẳng – bỗng bị ràng buộc bởi phong tục minh hôn với hồn ma, tạo nên phiêu lưu vừa lầy lội vừa cảm động.',
                'danh_gia'         => '8.5/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim'         => 'Siêu Nhân Nhí Đại Náo Rừng Xanh',
                'slug_phim'        => 'sieu-nhan-nhi-dai-nao-rung-xanh',
                'ngay_chieu'       => Carbon::parse('2025-04-11'),
                'thoi_luong'       => '82',
                'dao_dien'         => 'Behnoud Nekooei',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745076868/sieunhannhi_b5ggkn.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/sdV_dQiyG1s?si=tULeRwvNkGRihq9a"',
                'dien_vien'        => 'Hooman Hajabdollahi, Javad Pezeshkian, Hedayat Hashemi, Mir Taher Mazloomi, Tooraj Nasr',
                'nha_san_xuat'     => 'Hamed Jafari',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '13+',
                'mo_ta'            => 'Cậu bé mơ làm siêu anh hùng bỗng bước vào cuộc phiêu lưu giải cứu chú hổ trước nhóm thợ săn dữ tợn.',
                'danh_gia'         => '6.6/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim'         => 'Một Bộ Phim Minecraft',
                'slug_phim'        => 'mot-bo-phim-minecraft',
                'ngay_chieu'       => Carbon::parse('2025-04-04'),
                'thoi_luong'       => '101',
                'dao_dien'         => 'Jared Hess',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745077134/minecraft_kftqsr.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/O1f6L1Pqu28?si=FeCMKaUuNSwC26X9',
                'dien_vien'        => 'Jason Momoa, Jack Black, Emma Myers, Sebastian Eugene Hansen, Danielle Brooks',
                'nha_san_xuat'     => 'Roy Lee, Jill Messick',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '13+',
                'mo_ta'            => 'Bốn người bị kéo vào thế giới Minecraft, phải học cách sinh tồn và trở về nhà qua hành trình đầy khối lập phương kỳ ảo.',
                'danh_gia'         => '8.7/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim'         => 'Pororo: Thám Hiểm Đại Dương Xanh',
                'slug_phim'        => 'pororo-tham-hiem-dai-duong-xanh',
                'ngay_chieu'       => Carbon::parse('2025-04-04'),
                'thoi_luong'       => '71',
                'dao_dien'         => 'Yoon Je-wan',
                'hinh_anh'         => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745077334/thamhiemdaiduowng_rlsl4h.jpg',
                'trailer_ytb'      => 'https://www.youtube.com/embed/rTsV2tzDv6Y?si=1FoIFcIPMDOjjNTe',
                'dien_vien'        => 'Lee Sun, Lee Mi-ja, Ham Su-jung, Hong So-young, Jung Mi-sook',
                'nha_san_xuat'     => 'Kim Hyun-ho, Park Hyun-kuk',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '13+',
                'mo_ta'            => 'Pororo và bạn bè khám phá đại dương, đối mặt quái vật Seatus và học bài học về biển cả.',
                'danh_gia'         => '8.5/10',
                'tinh_trang'       => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'ten_phim' => 'JUNG KOOK: I AM STILL',
                'slug_phim' => 'jung-kook-i-am-still',
                'ngay_chieu' => Carbon::parse('2024-09-18'),
                'thoi_luong' => '93', // 1 giờ 33 phút
                'dao_dien' => 'Park Jun Soo',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202409/11559_103_100001.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/LWkh_hXeEeg?si=ki5WpumVYNwKPzFQ', // Giữ nguyên, không có link trailer chính thức trực tiếp từ tìm kiếm
                'dien_vien' => 'Jung Kook',
                'nha_san_xuat' => 'HYBE',
                'id_chi_tiet_the_loai' => 1, // Bạn tự ánh xạ sang ID tương ứng
                'gioi_han_do_tuoi' => '13+', // Theo thông tin tìm được
                'mo_ta' => 'Bộ phim tài liệu ghi lại hành trình 8 tháng của Jung Kook (BTS) với tư cách nghệ sĩ solo, bao gồm các cuộc phỏng vấn độc quyền chưa từng thấy, cảnh hậu trường và các màn trình diễn lôi cuốn trên sân khấu, hé lộ sự cống hiến và phát triển không ngừng của anh.',
                'danh_gia' => '8/10',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'TEE YOD: QUỶ ĂN TẠNG PHẦN 2',
                'slug_phim' => 'tee-yod-quy-an-tang-phan-2',
                'ngay_chieu' => Carbon::parse('2024-02-01'), // Giữ ngày bạn cung cấp, cần kiểm tra lại ngày chiếu chính thức tại VN nếu đây là phần 2
                'thoi_luong' => '90', // Cần xác nhận lại cho phần 2
                'dao_dien' => 'Taweewat Wantha',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11567_103_100006.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/xVVZvSybaEc?si=bSPn4ROqIJ4E0IuJ', // Giữ nguyên
                'dien_vien' => 'Nadech Kugimiya, Denise Jelilcha Kapaun, Mim Rattawadee Wongthong, Kajbundit Jaidee, Peerakrit Phacharabunyakiat, Natthacha Nina Jessica Padovan, Arisara Wongchalee, Pramet Noi-am', // Bổ sung diễn viên
                'nha_san_xuat' => 'Major Join Film, M Studio', // Cần kiểm tra nhà sản xuất cụ thể cho phần 2 nếu có
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '16+', // Giữ nguyên, phim kinh dị thường có giới hạn này hoặc cao hơn
                'mo_ta' => 'Tiếp nối những sự kiện kinh hoàng từ phần đầu, gia đình nhân vật chính tiếp tục đối mặt với những thế lực tà ác và những bí mật đen tối hơn được hé lộ.',
                'danh_gia' => '4/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'ROBOT HOANG DÃ',
                'slug_phim' => 'robot-hoang-da',
                'ngay_chieu' => Carbon::parse('2024-10-04'), // Cập nhật ngày chiếu chính xác hơn tại VN
                'thoi_luong' => '102', // Cập nhật thời lượng chính xác hơn (1 giờ 42 phút)
                'dao_dien' => 'Chris Sanders',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11482_103_100002.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/2l8_FNIBWLM?si=LBqapQ_4tWzCBkXr', // Giữ nguyên
                'dien_vien' => 'Lupita Nyong, Pedro Pascal, Catherine O, Bill Nighy, Kit Connor, Stephanie Hsu, Mark Hamill, Matt Berry, Ving Rhames', // Cập nhật và bổ sung diễn viên lồng tiếng
                'nha_san_xuat' => 'DreamWorks Animation', // Cập nhật nhà sản xuất
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '13+', // Cập nhật theo Lotte Cinema (Phim được phổ biến đến người xem dưới 13 tuổi với điều kiện xem cùng cha, mẹ hoặc người giám hộ)
                'mo_ta' => 'Một robot tên Roz tình cờ bị đắm tàu và dạt vào một hòn đảo hoang vắng. Tại đây, Roz phải học cách thích nghi với môi trường khắc nghiệt, xây dựng mối quan hệ với các loài động vật trên đảo và trở thành người mẹ bất đắc dĩ của một chú ngỗng con mồ côi.',
                'danh_gia' => '3/5', // Giữ nguyên hoặc cập nhật nếu có
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'CÁM',
                'slug_phim' => 'cam',
                'ngay_chieu' => Carbon::parse('2024-09-20'),
                'thoi_luong' => '122',
                'dao_dien' => 'Trần Hữu Tấn',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202409/11507_103_100004.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/_8qUFEmPQbc?si=1c2BWnCwIkjk5M-Y', // Giữ nguyên
                'dien_vien' => 'Rima Thanh Vy, Lâm Thanh Mỹ, Quốc Cường, Thúy Diễm, Hải Nam, Hạnh Thúy, Mai Thế Hiệp', // Bổ sung diễn viên
                'nha_san_xuat' => 'ProductionQ - Creative House, Hoàng Quân', // Bổ sung
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '16+', // Cần xác nhận lại, phim kinh dị thường là 16+ hoặc 18+
                'mo_ta' => 'Dựa trên câu chuyện cổ tích Tấm Cám quen thuộc nhưng được khai thác dưới góc nhìn đen tối và kinh dị hơn, tập trung vào nhân vật Cám và những uẩn khúc phía sau.',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'FUBAO: BẢO BỐI CỦA ÔNG',
                'slug_phim' => 'fubao-bao-boi-cua-ong',
                'ngay_chieu' => Carbon::parse('2024-10-11'),
                'thoi_luong' => '94',
                'dao_dien' => 'Shim Hyeong-jun, Thomas Ko',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11574_103_100002.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/6KxlC1Bt3C4?si=tTqScLL55JmpuHZg', // Cập nhật link trailer chính thức
                'dien_vien' => 'Fu Bao, Kang Cheol-won, Song Young-kwan', // Bổ sung
                'nha_san_xuat' => 'Everland', // Ghi chú thêm
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '13+', // Phim được phổ biến rộng rãi
                'mo_ta' => 'Bộ phim tài liệu cảm động ghi lại hành trình từ khi sinh ra cho đến lúc trưởng thành của Fu Bao, chú gấu trúc đầu tiên được sinh tại Hàn Quốc, cùng tình cảm gắn bó sâu sắc với hai người ông chăm sóc tại Everland trước khi chú trở về Trung Quốc.',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'BIỆT ĐỘI HOT GIRL',
                'slug_phim' => 'biet-doi-hot-girl',
                'ngay_chieu' => Carbon::parse('2024-10-25'),
                'thoi_luong' => '95',
                'dao_dien' => 'Vĩnh Khương',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11595_103_100001.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/GCxopxk_BwY?si=k3P6jcn-jhtKvQR9', // Giữ nguyên
                'dien_vien' => 'Cố NSND Hoàng Dũng, Hữu Vi, Nguyễn Trần Duy Nhất, Mr Kim, Yu Chu, Sam Sony, Bảo Uyên, Tuệ Minh, Thùy Trang, Ái Vân, Hoàng Sơn, Trần Ngọc Tú, Anna Linh', // Bổ sung đầy đủ diễn viên
                'nha_san_xuat' => 'VietKing Film',
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '16+', // Phim hành động thường có giới hạn này, cần kiểm tra lại
                'mo_ta' => 'Một bộ phim hành động Việt Nam xoay quanh một nhóm các cô gái xinh đẹp, tài năng và giỏi võ, cùng nhau thực hiện những nhiệm vụ nguy hiểm. Phim được quay tại nhiều quốc gia.',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'TRÒ CHƠI NHÂN TÍNH',
                'slug_phim' => 'tro-choi-nhan-tinh',
                'ngay_chieu' => Carbon::parse('2024-10-25'),
                'thoi_luong' => '110', // Giữ nguyên, cần xác nhận lại
                'dao_dien' => 'William Henry Aherne',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11592_103_100001.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/KvmVQpkv4Pw?si=-yRgYJ0C5Gai0vUj', // Giữ nguyên
                'dien_vien' => 'Worranit Thawornwong (Mook), Vachiravit Paisarnkulwong (August), Supachaya Sukbaiyen (Froy), Ngọc Lan Vy, Rapeepong Thapsuwan (Bright), Natnicha Lueanganan (Min), Naphat Na Ranong, Chalongrat Nobsamrong', // Bổ sung và làm rõ tên diễn viên
                'nha_san_xuat' => 'NHK', // Ghi chú thêm, cần tìm tên công ty sản xuất cụ thể
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '18+', // Phim kinh dị, sinh tồn thường có giới hạn cao
                'mo_ta' => 'Một nhóm học sinh tại một trường cấp ba danh tiếng bị cuốn vào một trò chơi đẫm máu và đầy ám ảnh, nơi bản năng sinh tồn và những góc khuất đen tối của nhân tính được phơi bày.',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'CÔ DÂU HÀO MÔN',
                'slug_phim' => 'co-dau-hao-mon',
                'ngay_chieu' => Carbon::parse('2024-10-18'),
                'thoi_luong' => '110', // Giữ nguyên, cần xác nhận lại
                'dao_dien' => 'Vũ Ngọc Đãng',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11556_103_100002.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/QJ8E9R70csY?si=59o0dvZN1Ij8JFC4', // Giữ nguyên
                'dien_vien' => 'Uyển Ân, Kiều Minh Tuấn, Lê Giang, Thu Trang, Samuel An, NSND Hồng Vân, Quỳnh Lương', // Bổ sung và làm rõ vai diễn
                'nha_san_xuat' => 'Will Vũ', // Ghi chú thêm, cần tìm tên công ty sản xuất cụ thể
                'id_chi_tiet_the_loai' => 1,
                'gioi_han_do_tuoi' => '16+', // Phim có thể chứa các yếu tố phù hợp với lứa tuổi 16+
                'mo_ta' => 'Câu chuyện hài hước và éo le của Tú Lạc, một cô gái cùng gia đình dàn dựng cuộc sống "phông bạt" xa hoa để cô có thể tiếp cận và trở thành con dâu của một gia đình tài phiệt, dẫn đến vô số tình huống dở khóc dở cười.',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
