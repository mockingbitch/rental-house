<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('cities')->truncate();

        $cities = [
            ['愛知県', 'Aichi', 'Aichi', 1],
            ['秋田県', 'Akita', 'Akita', 1],
            ['青森県', 'Aomori', 'Aomori', 1],
            ['千葉県', 'Chiba', 'Chiba', 1],
            ['愛媛県', 'Ehime', 'Ehime', 1],
            ['福井県', 'Fukui', 'Fukui', 1],
            ['福岡県', 'Fukuoka', 'Fukuoka', 1],
            ['福島県', 'Fukushima', 'Fukushima', 1],
            ['岐阜県', 'Gifu', 'Gifu', 1],
            ['群馬県', 'Gunma', 'Gunma', 1],
            ['広島県', 'Hiroshima', 'Hiroshima', 1],
            ['北海道', 'Hokkaido', 'Hokkaido', 1],
            ['兵庫県', 'Hyogo', 'Hyogo', 1],
            ['茨城県', 'Ibaraki', 'Ibaraki', 1],
            ['石川県', 'Ishikawa', 'Ishikawa', 1],
            ['岩手県', 'Iwate', 'Iwate', 1],
            ['香川県', 'Kagawa', 'Kagawa', 1],
            ['鹿児島県', 'Kagoshima', 'Kagoshima', 1],
            ['神奈川県', 'Kanagawa', 'Kanagawa', 1],
            ['高知県', 'Kochi', 'Kochi', 1],
            ['熊本県', 'Kumamoto', 'Kumamoto', 1],
            ['京都府', 'Kyoto', 'Kyoto', 1],
            ['三重県', 'Mie', 'Mie', 1],
            ['宮城県', 'Miyagi', 'Miyagi', 1],
            ['宮崎県', 'Miyazaki', 'Miyazaki', 1],
            ['長野県', 'Nagano', 'Nagano', 1],
            ['長崎県', 'Nagasaki', 'Nagasaki', 1],
            ['奈良県', 'Nara', 'Nara', 1],
            ['新潟県', 'Niigata', 'Niigata', 1],
            ['大阪府', 'Osaka', 'Osaka', 1],
            ['佐賀県', 'Saga', 'Saga', 1],
            ['埼玉県', 'Saitama', 'Saitama', 1],
            ['滋賀県', 'Shiga', 'Shiga', 1],
            ['島根県', 'Shimane', 'Shimane', 1],
            ['静岡県', 'Shizuoka', 'Shizuoka', 1],
            ['栃木県', 'Tochigi', 'Tochigi', 1],
            ['徳島県', 'Tokushima', 'Tokushima', 1],
            ['東京都', 'Tokyo', 'Tokyo', 1],
            ['鳥取県', 'Tottori', 'Tottori', 1],
            ['富山県', 'Toyama', 'Toyama', 1],
            ['和歌山県', 'Wakayama', 'Wakayama', 1],
            ['山形県', 'Yamagata', 'Yamagata', 1],
            ['山口県', 'Yamaguchi', 'Yamaguchi', 1],
            ['山梨県', 'Yamanashi', 'Yamanashi', 1],
            ['An Giang', 'An Giang', 'An Giang', 2],
            ['Ba Ria-Vung Tau', 'Ba Ria-Vung Tau', 'Bà Rịa - Vũng Tàu', 2],
            ['Bac Giang', 'Bac Giang', 'Bắc Giang', 2],
            ['Bac Kan', 'Bac Kan', 'Bắc Kạn', 2],
            ['Bac Lieu', 'Bac Lieu', 'Bạc Liêu', 2],
            ['Bac Ninh', 'Bac Ninh', 'Bắc Ninh', 2],
            ['Ben Tre', 'Ben Tre', 'Bến Tre', 2],
            ['Binh Dinh', 'Binh Dinh', 'Bình Định', 2],
            ['Binh Duong', 'Binh Duong', 'Bình Dương', 2],
            ['Binh Phuoc', 'Binh Phuoc', 'Bình Phước', 2],
            ['Binh Thuan', 'Binh Thuan', 'Bình Thuận', 2],
            ['Ca Mau', 'Ca Mau', 'Cà Mau', 2],
            ['Can Tho', 'Can Tho', 'Cần Thơ', 2],
            ['Cao Bang', 'Cao Bang', 'Cao Bằng', 2],
            ['Da Nang', 'Da Nang', 'Đà Nẵng', 2],
            ['Dak Lak', 'Dak Lak', 'Đắk Lắk', 2],
            ['Dak Nong', 'Dak Nong', 'Đắk Nông', 2],
            ['Dien Bien', 'Dien Bien', 'Điện Biên', 2],
            ['Dong Nai', 'Dong Nai', 'Đồng Nai', 2],
            ['Dong Thap', 'Dong Thap', 'Đồng Tháp', 2],
            ['Gia Lai', 'Gia Lai', 'Gia Lai', 2],
            ['Ha Giang', 'Ha Giang', 'Hà Giang', 2],
            ['Ha Nam', 'Ha Nam', 'Hà Nam', 2],
            ['Hanoi', 'Hanoi', 'Hà Nội', 2],
            ['Ha Tinh', 'Ha Tinh', 'Hà Tĩnh', 2],
            ['Hai Duong', 'Hai Duong', 'Hải Dương', 2],
            ['Hai Phong', 'Hai Phong', 'Hải Phòng', 2],
            ['Hau Giang', 'Hau Giang', 'Hậu Giang', 2],
            ['Hoa Binh', 'Hoa Binh', 'Hòa Bình', 2],
            ['Hung Yen', 'Hung Yen', 'Hưng Yên', 2],
            ['Khanh Hoa', 'Khanh Hoa', 'Khánh Hòa', 2],
            ['Kien Giang', 'Kien Giang', 'Kiên Giang', 2],
            ['Kon Tum', 'Kon Tum', 'Kon Tum', 2],
            ['Lai Chau', 'Lai Chau', 'Lai Châu', 2],
            ['Lam Dong', 'Lam Dong', 'Lâm Đồng', 2],
            ['Lang Son', 'Lang Son', 'Lạng Sơn', 2],
            ['Lao Cai', 'Lao Cai', 'Lào Cai', 2],
            ['Long An', 'Long An', 'Long An', 2],
            ['Nam Dinh', 'Nam Dinh', 'Nam Định', 2],
            ['Nghe An', 'Nghe An', 'Nghệ An', 2],
            ['Ninh Binh', 'Ninh Binh', 'Ninh Bình', 2],
            ['Ninh Thuan', 'Ninh Thuan', 'Ninh Thuận', 2],
            ['Phu Tho', 'Phu Tho', 'Phú Thọ', 2],
            ['Phu Yen', 'Phu Yen', 'Phú Yên', 2],
            ['Quang Binh', 'Quang Binh', 'Quảng Bình', 2],
            ['Quang Nam', 'Quang Nam', 'Quảng Nam', 2],
            ['Quang Ngai', 'Quang Ngai', 'Quảng Ngãi', 2],
            ['Quang Ninh', 'Quang Ninh', 'Quảng Ninh', 2],
            ['Quang Tri', 'Quang Tri', 'Quảng Trị', 2],
            ['Soc Trang', 'Soc Trang', 'Sóc Trăng', 2],
            ['Son La', 'Son La', 'Sơn La', 2],
            ['Tay Ninh', 'Tay Ninh', 'Tây Ninh', 2],
            ['Thai Binh', 'Thai Binh', 'Thái Bình', 2],
            ['Thai Nguyen', 'Thai Nguyen', 'Thái Nguyên', 2],
            ['Thanh Hoa', 'Thanh Hoa', 'Thanh Hóa', 2],
            ['Thua Thien Hue', 'Thua Thien Hue', 'Thừa Thiên Huế', 2],
            ['Tien Giang', 'Tien Giang', 'Tiền Giang', 2],
            ['Ho Chi Minh City', 'Ho Chi Minh City', 'TP Hồ Chí Minh', 2],
            ['Tra Vinh', 'Tra Vinh', 'Trà Vinh', 2],
            ['Tuyen Quang', 'Tuyen Quang', 'Tuyên Quang', 2],
            ['Vinh Long', 'Vinh Long', 'Vĩnh Long', 2],
            ['Vinh Phuc', 'Vinh Phuc', 'Vĩnh Phúc', 2],
            ['Yen Bai', 'Yen Bai', 'Yên Bái', 2],
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name_jp'       => $city[0],
                'name_en'       => $city[1],
                'name_vn'       => $city[2],
                'country_id'    => $city[3],
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
