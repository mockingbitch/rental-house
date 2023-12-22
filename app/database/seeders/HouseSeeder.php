<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        DB::table('houses')->truncate();

        // insert lessor
        // password = 123456
        User::where(['email' => 'lessor.111@gmail.com'])->forceDelete();
        $lessor = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'lessor.111@gmail.com',
            'password' => '$2y$10$ujhdYIkpa23U7ayvug3rdOnyhNx03O4ntgAlMsNLl/bSFIWJsxyF6',
            'description' => 'Some description here.',
            'avatar' => 'https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png',
            'ward_code' => '00019',
            'status' => 1,
            // 'country_id' => ,
            // 'city_id' => ,
            // 'vendor' => ,
            'role'  => 'LESSOR',
            'region' => 'Viet Nam',
            // 'remember_token' => ,
            'email_verified_at' => '2022-01-15 12:30:00',
            'birthday' => '2000-01-12',
        ]);

        $houses =
        [
            [
                "id" => 1,
                "name" => "Ba Na house",
                "description" => "A beautiful house in Vietnam",
                "address" => "101 Vong street",
                "verified_at" => "2021-10-11 20:05:00",
                "thumbnail" => "https://buffer.com/cdn-cgi/image/w=1000,fit=contain,q=90,f=auto/library/content/images/size/w1200/2023/09/instagram-image-size.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "06",
                "district_code" => "058",
                "ward_code" => "00256"
            ],
            [
                "id" => 2,
                "name" => "Sunny Villa",
                "description" => "Spacious villa with a view",
                "address" => "22 Sunshine Avenue",
                "verified_at" => "2021-09-15 18:30:00",
                "thumbnail" => "https://thanhvietcorp.vn/uploads/images/Bao%20chi/cac-mau-nha-vuon-dep.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "24",
                "district_code" => "215",
                "ward_code" => "07279"
            ],
            [
                "id" => 3,
                "name" => "Mountain Retreat",
                "description" => "Cozy house nestled in the mountains",
                "address" => "45 Serenity Lane",
                "verified_at" => "2021-11-05 12:45:00",
                "thumbnail" => "https://msmobile.com.vn/upload_images/images/tai-hinh-nen-nha-dep-cho-may-tinh-1.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "14",
                "district_code" => "116",
                "ward_code" => "00361"
            ],
            [
                "id" => 4,
                "name" => "Urban Oasis",
                "description" => "Modern house in the heart of the city",
                "address" => "7 Urban Plaza",
                "verified_at" => "2021-08-20 15:20:00",
                "thumbnail" => "https://angialam.vn/wp-content/uploads/2018/03/hinh-ngoi-nha-dep-cty-an-gia-lam.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "26",
                "district_code" => "246",
                "ward_code" => "08845"
            ],
            [
                "id" => 5,
                "name" => "Sea View Cottage",
                "description" => "Charming cottage by the sea",
                "address" => "10 Oceanfront Road",
                "verified_at" => "2021-12-02 08:10:00",
                "thumbnail" => "https://cityahomes.vn/wp-content/uploads/2021/08/Tai-sao-nen-thiet-ke-nha-san-dep.png",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "30",
                "district_code" => "297",
                "ward_code" => "11044"
            ],
            [
                "id" => 6,
                "name" => "Riverside Retreat",
                "description" => "Tranquil house by the river",
                "address" => "30 River Lane",
                "verified_at" => "2021-07-08 14:00:00",
                "thumbnail" => "https://xaydungso.vn/webroot/img/images/mau-nha-san-dep-10.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "27",
                "district_code" => "259",
                "ward_code" => "09298"
            ],
            [
                "id" => 7,
                "name" => "Meadowview Mansion",
                "description" => "Grand mansion with a meadow view",
                "address" => "55 Meadow Drive",
                "verified_at" => "2021-09-30 17:45:00",
                "thumbnail" => "https://bizweb.dktcdn.net/100/369/827/files/50271371-759755064399890-6462199697548247040-n5.jpg?v=1620638792735",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "17",
                "district_code" => "152",
                "ward_code" => "04954"
            ],
            [
                "id" => 8,
                "name" => "Forest Cabin",
                "description" => "Cozy cabin surrounded by trees",
                "address" => "18 Pine Grove",
                "verified_at" => "2021-11-20 10:30:00",
                "thumbnail" => "https://angialam.vn/wp-content/uploads/2018/03/hinh-ngoi-nha-dep-cty-an-gia-lam.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "12",
                "district_code" => "108",
                "ward_code" => "03532"
            ],
            [
                "id" => 9,
                "name" => "Sunset Serenity",
                "description" => "House with a stunning sunset view",
                "address" => "8 Horizon Place",
                "verified_at" => "2021-12-15 19:20:00",
                "thumbnail" => "https://angialam.vn/wp-content/uploads/2018/03/ngoi-nha-dep-cty-an-gia-lam-1.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "92",
                "district_code" => "919",
                "ward_code" => "31189"
            ],
            [
                "id" => 10,
                "name" => "Desert Oasis",
                "description" => "Modern oasis in the desert",
                "address" => "12 Sand Dune Avenue",
                "verified_at" => "2021-10-05 16:10:00",
                "thumbnail" => "https://angialam.vn/wp-content/uploads/2018/03/cty-xay-dung-nha-dep.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "91",
                "district_code" => "905",
                "ward_code" => "30889"
            ],
            [
                "id" => 11,
                "name" => "Historic Manor",
                "description" => "Elegant historic manor",
                "address" => "25 Heritage Lane",
                "verified_at" => "2021-08-12 12:15:00",
                "thumbnail" => "https://angialam.vn/wp-content/uploads/2018/03/nha-dep-an-gia-lam.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "93",
                "district_code" => "932",
                "ward_code" => "31359"
            ],
            [
                "id" => 12,
                "name" => "Lakeside Lodge",
                "description" => "Charming lodge by the lake",
                "address" => "40 Lakeshore Drive",
                "verified_at" => "2021-06-25 08:40:00",
                "thumbnail" => "https://angialam.vn/wp-content/uploads/2018/03/hinh-nha-dep-an-gia-lam.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "25",
                "district_code" => "231",
                "ward_code" => "08071"
            ],
            [
                "id" => 13,
                "name" => "City Skyline Apartment",
                "description" => "Apartment with a view of the city skyline",
                "address" => "5 Downtown Plaza",
                "verified_at" => "2021-09-10 22:30:00",
                "thumbnail" => "https://file3.qdnd.vn/data/images/0/2022/02/19/thuthuytv/nhasan.jpg?dpi=150&quality=100&w=870",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "83",
                "district_code" => "835",
                "ward_code" => "29065"
            ],
            [
                "id" => 14,
                "name" => "Island Paradise Villa",
                "description" => "Luxurious villa on a tropical island",
                "address" => "Island Paradise, 123 Palm Beach",
                "verified_at" => "2021-12-30 14:50:00",
                "thumbnail" => "https://leadtravel.com.vn/wp-content/uploads/2021/04/nha-san-mai-chau.jpg",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "95",
                "district_code" => "959",
                "ward_code" => "31957"
            ],
            [
                "id" => 15,
                "name" => "Snowy Chalet",
                "description" => "Cozy chalet in the snowy mountains",
                "address" => "15 Frosty Heights",
                "verified_at" => "2021-11-28 11:05:00",
                "thumbnail" => "https://tostemvietnam.com/wp-content/uploads/2023/05/biet-thu-dep.png",
                "status" => "1",
                "category_id" => 1,
                "province_code" => "93",
                "district_code" => "933",
                "ward_code" => "31381"
            ]
        ];

        foreach ($houses as $house) {
            DB::table('houses')->insert([
                'lessor_id' => $lessor->id,
                'name' => $house['name'],
                'description' => $house['description'],
                'province_code' => $house['province_code'],
                'district_code' => $house['district_code'],
                'ward_code' => $house['ward_code'],
                'address' => $house['address'],
                'verified_at' => $house['verified_at'],
                'thumbnail' => $house['thumbnail'],
                'status' => $house['status'],
                'category_id' => $house['category_id'],
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
