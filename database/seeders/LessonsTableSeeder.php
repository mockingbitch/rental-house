<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('lessons')->truncate();

        $lessons = [
            [1, 'Math 4', 1, 1000.00, 'Math for children', 1, 9, 12, 10, 20, 3, 30, '1', 'https://img.freepik.com/free-vector/cartoon-math-word-with-math-symbols_1308-97111.jpg?w=2000', NULL, NULL, '2023-07-28', '2023-07-30', 5, NULL, '1', '1', '1', 2, 0, NULL, NULL, '2023-07-27 02:46:45', NULL, NULL],
            [2, 'Physic 2', 1, 1200.00, 'Physic for children', 4, 8, 12, 5, 7, 2, 20, '1', 'https://assets.ltkcontent.com/images/26593/physics_27c5571306.jpg', NULL, NULL, '2023-07-26', '2023-08-26', 7, NULL, '1', '1', '1', 1, 45, NULL, NULL, '2023-07-26 02:46:48', NULL, NULL],
            [3, 'Chemistry 5', 1, 1500.00, 'Chemistry for children', 5, 10, 14, 3, 12, 4, 30, '1', 'https://img.freepik.com/free-vector/hand-drawn-colorless-chemistry-background_23-2148158838.jpg?w=2000', NULL, NULL, '2023-08-26', '2023-09-26', 2, NULL, '1', '1', '1', 0, 45, NULL, NULL, '2023-07-25 02:46:54', NULL, NULL],
            [4, 'Music 4', 1, 800.00, 'Learn music', 10, 8, 12, 15, 20, 3, 25, '1', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrJBA1UJRrp_xdpAL-9-kKVpcbfVpvd-K7nPnCFlpDqFDyarMZajQnqNkTwKtNQEAwrxc&usqp=CAU', NULL, NULL, '2023-08-16', '2023-10-26', 1, NULL, '1', '1', '1', 1, 30, NULL, NULL, '2023-07-24 02:46:56', NULL, NULL],
            [5, 'Phylosophy 5', 1, 2000.00, 'Lean how to thing', 14, 10, 15, 6, 20, 4, 25, '1', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQYi6nENmz00divrmdwtitbOLAijKv3FBqKHS9fjSIMq9aKM7zb5Wg14WmDF5fT_W4AZlM&usqp=CAU', NULL, NULL, '2023-07-26', '2023-11-12', 5, NULL, '1', '1', '1', 2, 30, NULL, NULL, '2023-07-23 02:46:58', NULL, NULL],
            [6, 'Calculation', 1, 3000.00, 'Learn how to calculate quickly', 11, 6, 15, 11, 15, 2, 30, '1', 'https://miro.medium.com/v2/resize:fit:300/1*h7N9s4DuiXGG0Kt1W3OqKQ.jpeg', NULL, NULL, '2023-07-30', '2023-12-14', 7, NULL, '1', '1', '1', 0, 30, NULL, NULL, '2023-07-22 02:47:01', NULL, NULL],
            [7, 'Math 9', 1, 1200.00, 'Math for secondary school', 13, 12, 15, 10, 15, 3, 25, '1', 'https://idvielts.com/wp-content/uploads/2019/08/ielts-maths-topic.jpg', NULL, NULL, '2023-07-28', '2023-12-30', 2, NULL, '1', '1', '1', 1, 0, NULL, NULL, '2023-07-21 02:47:03', NULL, NULL],
            [8, 'English 7', 1, 2300.00, 'English for student', 2, 12, 16, 4, 6, 4, 45, '1', 'https://www.fpacademy.co.in/blog/wp-content/uploads/2022/09/How-to-Learn-English-Speaking-at-Home-960x540-1.jpg', NULL, NULL, '2023-08-15', '2023-11-25', 3, NULL, '1', '1', '1', 3, 0, NULL, NULL, '2023-07-20 02:47:06', NULL, NULL],
            [9, 'France 5', 1, 1100.00, 'Learn france for beginner', 2, 13, 17, 8, 15, 3, 45, '1', 'https://www.state.gov/wp-content/uploads/2018/11/France-1980x1406.jpg', NULL, NULL, '2023-08-16', '2023-11-25', 2, NULL, '1', '1', '1', 1, 15, NULL, NULL, '2023-07-19 02:47:09', NULL, NULL],
            [10, 'Chinese', 1, 900.00, 'Lean chinese for student', 14, 8, 15, 12, 23, 4, 45, '1', 'https://cdn.britannica.com/89/179589-138-3EE27C94/Overview-Great-Wall-of-China.jpg?w=800&h=450&c=crop', NULL, NULL, '2023-08-17', '2023-12-21', 3, NULL, '1', '1', '1', 3, 0, NULL, NULL, '2023-07-18 02:47:12', NULL, NULL],
            [11, 'Cooking', 1, 1245.00, 'Learn how to cooking', 12, 6, 15, 15, 20, 1, 32, '1', 'https://www.unlockfood.ca/getmedia/79cc0763-3b98-4333-897a-d41d5ec5fbbc/mom-and-daughter-cooking.aspx?width=830&height=553', NULL, NULL, '2023-08-26', '2023-10-26', 6, NULL, '1', '1', '1', 1, 45, NULL, NULL, '2023-07-17 02:47:14', NULL, NULL],
            [12, 'Piano', 1, 1900.00, 'Piano in level 1', 1, 6, 15, 5, 10, 2, 20, '1', 'https://d28z68mqtlsfzd.cloudfront.net/app/uploads/2019/09/26090359/piano-keyboard-white-keys-pattern-of-notes-1024x512.png', NULL, NULL, '2023-08-10', '2023-09-02', 2, NULL, '1', '1', '1', 0, 20, NULL, NULL, '2023-07-16 02:47:18', NULL, NULL],
            [13, 'Piano 2', 1, 2000.00, 'Piano in level 2', 5, 12, 17, 4, 11, 3, 30, '1', 'https://play-lh.googleusercontent.com/HYDQM6g4YEmkFOgzdaMeRkEoEoWoMSdIVwjGc7RBfctejaEBiWHK216Td7S1L7a4Gg=w526-h296-rw', NULL, NULL, '2023-09-26', '2023-11-13', 6, NULL, '1', '1', '1', 1, 50, NULL, NULL, '2023-07-15 02:47:20', NULL, NULL],
            [14, 'Camping', 1, 2500.00, 'Camping', 5, 10, 18, 20, 26, 1, 25, '1', 'https://dulichhanoi.vn/wp-content/uploads/2021/05/Camping-la-gi-800.jpg', NULL, NULL, '2023-10-15', '2023-12-31', 3, NULL, '1', '1', '1', 0, 55, NULL, NULL, '2023-07-14 02:47:22', NULL, NULL],
            [15, 'Python', 1, 700.00, 'Learn Python language in basic', 6, 10, 15, 15, 20, 3, 35, '1', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAJpdHv4c4di6AhVbgclG1mybuNQJQjswQjZe8sGYN-Agip7BFVMBQ_pstINcWP7qxp1U&usqp=CAU', NULL, NULL, '2023-12-26', '2024-07-26', 9, NULL, '1', '1', '1', 2, 5, NULL, NULL, '2023-07-13 02:47:24', NULL, NULL],
            [16, 'C#', 1, 888.00, 'Learn C#', 8, 12, 15, 12, 25, 3, 40, '1', 'https://visualstudiomagazine.com/-/media/ECG/visualstudiomagazine/Images/introimages/CodeOnScreen.gif', NULL, NULL, '2023-12-12', '2024-05-26', 10, NULL, '1', '1', '1', 1, 25, NULL, NULL, '2023-07-12 02:47:27', NULL, NULL],
            [17, 'Aerobic', 1, 500.00, 'Aerobic class for children', 8, 8, 12, 10, 12, 1, 20, '1', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaYZGK_Zb9fftth3tZ3anX1b2IGPPT7xSXcA&usqp=CAU', NULL, NULL, '2023-09-02', '2023-12-12', 2, NULL, '1', '1', '1', 1, 35, NULL, NULL, '2023-07-11 02:47:29', NULL, NULL],
            [18, 'Dance', 1, 2000.00, 'Teach dance for children', 3, 9, 13, 10, 15, 1, 40, '1', 'https://www.avivaindia.com/sites/default/files/Dance.jpg', NULL, NULL, '2023-08-26', '2023-12-22', 9, NULL, '1', '1', '1', 2, 15, NULL, NULL, '2023-07-10 02:47:31', NULL, NULL],
            [19, 'Ballet', 1, 2500.00, 'Learn ballet dance from children', 13, 6, 12, 10, 12, 2, 25, '1', 'https://i.ytimg.com/vi/pJ3sECWr5Xg/maxresdefault.jpg', NULL, NULL, '2023-09-23', '2023-11-24', 3, NULL, '1', '1', '1', 0, 45, NULL, NULL, '2023-07-09 02:47:33', NULL, NULL],
            [20, 'math ', 1, 1000.00, 'Math for very small children', 3, 5, 7, 3, 6, 2, 23, '1', 'https://gurukultheschool.com/blog/wp-content/uploads/2019/12/Tips-to-Help-Your-Child-Embrace-Math-Happily.jpg', NULL, NULL, '2023-10-15', '2023-12-26', 12, NULL, '1', '1', '1', 0, 25, NULL, NULL, '2023-07-08 02:47:35', NULL, NULL],
            
        ];

        foreach ($lessons as $lesson) {
            DB::table('lessons')->insert([
                'id' => $lesson[0],
                'title' => $lesson[1],
                'teacher_id' => $lesson[2],
                'price' => $lesson[3],
                'description' => $lesson[4],
                'category_id' => $lesson[5],
                'target_age_from' => $lesson[6],
                'target_age_to' => $lesson[7],
                'min_learner' => $lesson[8],
                'max_learner' => $lesson[9],
                'number_of_meets' => $lesson[10],
                'total_of_meets' => $lesson[11],
                'language' => $lesson[12],
                'cover_image' => $lesson[13],
                'short_video_for_parent' => $lesson[14],
                'short_video_for_learner' => $lesson[15],
                'start_date' => $lesson[16],
                'end_date' => $lesson[17],
                'template' => $lesson[18],
                'note' => $lesson[19],
                'status' => $lesson[20],
                'style' => $lesson[21],
                'currency' => $lesson[22],
                'lesson_hour' => $lesson[23],
                'lesson_minute' => $lesson[24],
                'lesson_content' => $lesson[25],
                'teacher_experience' => $lesson[26],
                'created_at' => $lesson[27],
                'updated_at' => $lesson[28],
                'deleted_at' => $lesson[29],
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
