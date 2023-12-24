<?php

namespace Database\Seeders;

use App\Constants\TagConstant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        DB::table('tags')->truncate();
        DB::table('rooms')->truncate();

        $tags = [
            ['Phòng ngủ chính', 'Master Bedroom', 'Phòng ngủ chính với không gian riêng tư và thoải mái.', 'Master bedroom with private and comfortable space.'],
            ['Phòng khách', 'Living Room', 'Phòng khách với thiết kế hiện đại và thoải mái.', 'Modern and comfortable living room.'],
            ['Phòng tắm sang trọng', 'Luxurious Bathroom', 'Phòng tắm sang trọng với các tiện nghi hiện đại.', 'Luxurious bathroom with modern amenities.'],
            ['Phòng làm việc', 'Home Office', 'Phòng làm việc tại nhà với không gian thoải mái và tiện nghi.', 'Home office with comfortable and functional space.'],
            ['Phòng ăn', 'Dining Room', 'Phòng ăn với bàn ăn thoải mái và không gian ấm cúng.', 'Dining room with a comfortable table and a cozy atmosphere.'],
            ['Phòng trẻ em', 'Kids Room', 'Phòng trẻ em với thiết kế vui nhộn và an toàn.', 'Kids room with playful and safe design.'],
            ['Phòng tập gym', 'Home Gym', 'Phòng tập gym tại nhà với đầy đủ trang thiết bị.', 'Home gym with a complete set of equipment.'],
            ['Phòng giải trí', 'Entertainment Room', 'Phòng giải trí với TV lớn và sofa thoải mái.', 'Entertainment room with a large TV and comfortable sofa.'],
            ['Phòng đọc sách', 'Reading Nook', 'Góc đọc sách nhỏ gọn với đèn đọc và ghế thoải mái.', 'Cozy reading nook with a reading lamp and a comfortable chair.'],
            ['Phòng xông hơi', 'Sauna Room', 'Phòng xông hơi với thiết kế sang trọng và trang thiết bị hiện đại.', 'Sauna room with luxurious design and modern equipment.'],
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name_en'           => $tag[0],
                'name_vi'           => $tag[1],
                'description_vi'    => $tag[2],
                'description_en'    => $tag[3],
            ]);
        }

        $rooms =
        [
            [
              "id" => 1,
              "house_id" => 1,
              "name" => "Master Bedroom",
              "description" => "Luxurious master bedroom with a view",
              "floor" => "2",
              "images" => "https://xuonggooccho.com/ckfinder/userfiles/files/anh-phong-ngu.jpg, https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg, https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg, https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg",
              "price" => 8000000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "1,2"
            ],
            [
              "id" => 2,
              "house_id" => 2,
              "name" => "Living Room Suite",
              "description" => "Spacious living room suite with modern design",
              "floor" => "1",
              "images" => "https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg",
              "price" => 5000000.0,
              "capacity" => 3,
              "status" => "1",
              "tags" => "2,3,4"
            ],
            [
              "id" => 3,
              "house_id" => 3,
              "name" => "Private Bathroom",
              "description" => "Private bathroom with modern amenities",
              "floor" => "1",
              "images" => "https://noithatbaby.com/images/Product/phong-ngu-hien-dai-anh-thang-bia-1.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg",
              "price" => 3000000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "1,5"
            ],
            [
              "id" => 4,
              "house_id" => 4,
              "name" => "Cozy Home Office",
              "description" => "Comfortable home office with a great view",
              "floor" => "3",
              "images" => "https://xuonggooccho.com/ckfinder/userfiles/files/Hinh-anh-phong-ngu-dep-1.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg",
              "price" => 4000000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "4,6,8"
            ],
            [
              "id" => 5,
              "house_id" => 5,
              "name" => "Dining Room Oasis",
              "description" => "Relaxing dining room with a garden view",
              "floor" => "1",
              "images" => "https://xuonggooccho.com/uploads/news/thiet-ke-phong-ngu-16m2-dang-mo.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg",
              "price" => 2500000.0,
              "capacity" => 4,
              "status" => "1",
              "tags" => "3,5,9"
            ],
            [
              "id" => 6,
              "house_id" => 6,
              "name" => "Kids Playroom",
              "description" => "Fun and colorful playroom for kids",
              "floor" => "1",
              "images" => "https://noithatmanhhe.vn/media/20558/4-noi-that-phong-ngu-be-trai-mau-xanh-noi-that-manh-he.jpg?width=700&height=560&rmode=boxpad",
              "price" => 2000000.0,
              "capacity" => 3,
              "status" => "1",
              "tags" => "1,2,7"
            ],
            [
              "id" => 7,
              "house_id" => 7,
              "name" => "Private Gym",
              "description" => "Fully equipped private gym for fitness enthusiasts",
              "floor" => "2",
              "images" => "https://feeldecor.com.vn/wp-content/uploads/2017/05/thiet-ke-thi-cong-noi-that-phong-ngu_feeldecor-11.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg,https://resize.sudospaces.com/noithattoancau/2021/09/thiet-ke-noi-that-phong-ngu-19.jpg",
              "price" => 6000000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "6,8,10"
            ],
            [
              "id" => 8,
              "house_id" => 8,
              "name" => "Entertainment Hub",
              "description" => "Entertainment room with a large screen TV",
              "floor" => "1",
              "images" => "https://image-us.eva.vn/upload/1-2019/images/2019-03-14/mau-noi-that-phong-ngu-dep-co-thiet-ke-van-nguoi-me-16-1552550126-203-width600height423.jpg",
              "price" => 4500000.0,
              "capacity" => 5,
              "status" => "1",
              "tags" => "2,3,7"
            ],
            [
              "id" => 9,
              "house_id" => 9,
              "name" => "Reading Nook",
              "description" => "Cozy reading nook with natural light",
              "floor" => "3",
              "images" => "https://cgarchitects.vn/img/thiet-ke-can-ho-05/phong-ngu_05.jpg",
              "price" => 3000000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "4,5,9"
            ],
            [
              "id" => 10,
              "house_id" => 10,
              "name" => "Sauna Retreat",
              "description" => "Luxurious sauna room for relaxation",
              "floor" => "2",
              "images" => "https://noithattrevietnam.com/uploaded/2019/11/1-trang-tri-phong-ngu-bang-anh.jpg",
              "price" => 7000000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "1,6,10"
            ],
            [
              "id" => 11,
              "house_id" => 11,
              "name" => "Skyview Bedroom",
              "description" => "Bedroom with a breathtaking view of the sky",
              "floor" => "5",
              "images" => "https://noithattrevietnam.com/uploaded/2019/11/2-cach-trang-tri-phong-ngu-bang-anh.jpg",
              "price" => 9000000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "1,2,8"
            ],
            [
              "id" => 12,
              "house_id" => 12,
              "name" => "Nature-themed Suite",
              "description" => "Suite designed with a nature theme",
              "floor" => "2",
              "images" => "https://cdn.vietnammoi.vn/1881912202022777/images/anh-phong-ngu-chill-2-20220518180446152.jpg?width=700",
              "price" => 5500000.0,
              "capacity" => 3,
              "status" => "1",
              "tags" => "3,4,9"
            ],
            [
              "id" => 13,
              "house_id" => 13,
              "name" => "Spa-inspired Bathroom",
              "description" => "Bathroom designed for a spa-like experience",
              "floor" => "1",
              "images" => "https://cdn.vietnammoi.vn/1881912202022777/images/anh-phong-ngu-chill-1-20220518180445531.jpg?width=700",
              "price" => 3500000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "5,6,10"
            ],
            [
              "id" => 14,
              "house_id" => 14,
              "name" => "Artistic Home Office",
              "description" => "Artfully designed home office for creativity",
              "floor" => "4",
              "images" => "https://cdn.vietnammoi.vn/1881912202022777/images/anh-phong-ngu-chill-3-20220518180446442.jpg?width=700",
              "price" => 4200000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "2,7,8"
            ],
            [
              "id" => 15,
              "house_id" => 15,
              "name" => "Family Dining Room",
              "description" => "Warm and inviting dining room for family meals",
              "floor" => "1",
              "images" => "https://idphome.vn/wp-content/uploads/2021/07/Mau-noi-that-phong-ngu-chung-cu-cao-cap-PN6809.jpg",
              "price" => 2800000.0,
              "capacity" => 4,
              "status" => "1",
              "tags" => "1,3,9"
            ],
            [
              "id" => 16,
              "house_id" => 1,
              "name" => "Children's Room",
              "description" => "Colorful and playful room for children",
              "floor" => "2",
              "images" => "https://muabanghecu.com/wp-content/uploads/2020/05/noi-that-phong-ngu-thanh-ly-gia-re.jpg",
              "price" => 2300000.0,
              "capacity" => 3,
              "status" => "1",
              "tags" => "2,4,6"
            ],
            [
              "id" => 17,
              "house_id" => 2,
              "name" => "Private Cinema",
              "description" => "Home cinema with a large screen and comfy seats",
              "floor" => "1",
              "images" => "https://sbshouse.vn/wp-content/uploads/2022/01/M%E1%BA%ABu-nh%C3%A0-2-t%E1%BA%A7ng-%C4%91%E1%BA%B9p-6.jpg",
              "price" => 6500000.0,
              "capacity" => 5,
              "status" => "1",
              "tags" => "3,5,7"
            ],
            [
              "id" => 18,
              "house_id" => 3,
              "name" => "Executive Suite",
              "description" => "Luxurious suite for executives with a view",
              "floor" => "6",
              "images" => "https://edeninterior.vn/wp-content/uploads/2022/09/anh-trang-tri-phong-ngu-4.jpg",
              "price" => 7500000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "1,7,8"
            ],
            [
              "id" => 19,
              "house_id" => 4,
              "name" => "Zen Garden Room",
              "description" => "Room with a tranquil Zen garden view",
              "floor" => "2",
              "images" => "https://kientrucdep24h.vn/upload/cac-mau-trang-tri-phong-khach-dep-voi-thien-nhien.jpg",
              "price" => 3200000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "4,6,10"
            ],
            [
              "id" => 20,
              "house_id" => 5,
              "name" => "Smart Home Office",
              "description" => "Modern and technology-equipped home office",
              "floor" => "5",
              "images" => "https://rumi.vn/thuvien/elib/2016/10/1477350605-18-mau-noi-that-phong-khach-thiet-ke-gan-gui-voi-thien-nhien-9.jpg",
              "price" => 4700000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "2,5,9"
            ],
            [
              "id" => 21,
              "house_id" => 6,
              "name" => "Ocean View Suite",
              "description" => "Suite with a breathtaking view of the ocean",
              "floor" => "3",
              "images" => "https://amore-architecture.vn/wp-content/uploads/2020/12/phong-khach-12m2-4.jpg",
              "price" => 8500000.0,
              "capacity" => 3,
              "status" => "1",
              "tags" => "1,3,8"
            ],
            [
              "id" => 22,
              "house_id" => 7,
              "name" => "Tech Hub Room",
              "description" => "Room equipped with the latest technology",
              "floor" => "1",
              "images" => "https://icdn.dantri.com.vn/2019/02/02/tetxua-1-1549062047573.jpg",
              "price" => 3800000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "4,7,10"
            ],
            [
              "id" => 23,
              "house_id" => 8,
              "name" => "Meditation Room",
              "description" => "Room designed for peaceful meditation",
              "floor" => "4",
              "images" => "https://donggia.vn/wp-content/uploads/2022/02/3.jpg",
              "price" => 2700000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "1,5,9"
            ],
            [
              "id" => 24,
              "house_id" => 9,
              "name" => "Rooftop Terrace Room",
              "description" => "Room with access to a scenic rooftop terrace",
              "floor" => "7",
              "images" => "https://donggia.vn/wp-content/uploads/2022/02/phong-khach-4.jpg",
              "price" => 5200000.0,
              "capacity" => 4,
              "status" => "1",
              "tags" => "2,6,8"
            ],
            [
              "id" => 25,
              "house_id" => 10,
              "name" => "Home Bar Lounge",
              "description" => "Lounge with a stylish home bar setup",
              "floor" => "1",
              "images" => "https://donggia.vn/wp-content/uploads/2020/08/thiet-ke-noi-that-phong-khach-dep-hien-dai-2021-2.jpg",
              "price" => 4300000.0,
              "capacity" => 5,
              "status" => "1",
              "tags" => "3,7,10"
            ],
            [
              "id" => 26,
              "house_id" => 11,
              "name" => "Cityscape Bedroom",
              "description" => "Bedroom with a stunning view of the cityscape",
              "floor" => "6",
              "images" => "https://edeninterior.vn/wp-content/uploads/2022/09/anh-trang-tri-phong-ngu-8.jpg",
              "price" => 9200000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "1,2,9"
            ],
            [
              "id" => 27,
              "house_id" => 12,
              "name" => "Pet-friendly Room",
              "description" => "Room designed to accommodate pets",
              "floor" => "3",
              "images" => "https://govi.vn/wp-content/uploads/2022/04/thiet-ke-phong-doc-sach-khong-gian-mo-giup-can-phong-rong-rai-thoang-dang.jpg",
              "price" => 3200000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "3,6,8"
            ],
            [
              "id" => 28,
              "house_id" => 13,
              "name" => "Elegant Spa Bathroom",
              "description" => "Bathroom with an elegant spa-like ambiance",
              "floor" => "2",
              "images" => "https://www.shutterstock.com/shutterstock/photos/2157520005/display_1500/stock-photo-empty-interior-room-d-illustration-2157520005.jpg",
              "price" => 3800000.0,
              "capacity" => 1,
              "status" => "1",
              "tags" => "4,5,10"
            ],
            [
              "id" => 29,
              "house_id" => 14,
              "name" => "Home Library Nook",
              "description" => "Cozy nook designed for reading and relaxation",
              "floor" => "5",
              "images" => "https://donggia.vn/wp-content/uploads/2020/12/phong-khach-biet-thu-cao-cap.jpg",
              "price" => 2600000.0,
              "capacity" => 2,
              "status" => "1",
              "tags" => "2,7,9"
            ],
            [
              "id" => 30,
              "house_id" => 15,
              "name" => "Sunset View Lounge",
              "description" => "Lounge with a beautiful view of the sunset",
              "floor" => "1",
              "images" => "https://shac.vn/wp-content/uploads/2019/05/mau-phong-ngu-tan-co-dien-co-thiet-ke-noi-that-dep-mau-sachai-hoa-the-hien-ca-tinh-rieng-cua-gia-chu.jpg",
              "price" => 4900000.0,
              "capacity" => 4,
              "status" => "1",
              "tags" => "1,5,8"
            ]
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insert([
                'house_id' => $room['house_id'],
                'name' => $room['name'],
                'description' => $room['description'],
                'floor' => $room['floor'],
                'images' => $room['images'],
                'price' => $room['price'],
                'capacity' => $room['capacity'],
                'status' => $room['status'],
                'tags' => $room['tags'],
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
