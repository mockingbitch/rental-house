<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();

        $categories = [
            ['デベロッパー', 'Developer', 'Lập trình viên', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.5 7V14.5C27.5 14.6326 27.4473 14.7598 27.3536 14.8536C27.2598 14.9473 27.1326 15 27 15H17.5V5.5C17.5 5.36739 17.5527 5.24021 17.6464 5.14645C17.7402 5.05268 17.8674 5 18 5H25.5C26.0304 5 26.5391 5.21071 26.9142 5.58579C27.2893 5.96086 27.5 6.46957 27.5 7ZM15 5H7.5C6.96957 5 6.46086 5.21071 6.08579 5.58579C5.71071 5.96086 5.5 6.46957 5.5 7V14.5C5.5 14.6326 5.55268 14.7598 5.64645 14.8536C5.74021 14.9473 5.86739 15 6 15H15.5V5.5C15.5 5.36739 15.4473 5.24021 15.3536 5.14645C15.2598 5.05268 15.1326 5 15 5ZM27 17H17.5V26.5C17.5 26.6326 17.5527 26.7598 17.6464 26.8536C17.7402 26.9473 17.8674 27 18 27H25.5C26.0304 27 26.5391 26.7893 26.9142 26.4142C27.2893 26.0391 27.5 25.5304 27.5 25V17.5C27.5 17.3674 27.4473 17.2402 27.3536 17.1464C27.2598 17.0527 27.1326 17 27 17ZM5.5 17.5V25C5.5 25.5304 5.71071 26.0391 6.08579 26.4142C6.46086 26.7893 6.96957 27 7.5 27H15C15.1326 27 15.2598 26.9473 15.3536 26.8536C15.4473 26.7598 15.5 26.6326 15.5 26.5V17H6C5.86739 17 5.74021 17.0527 5.64645 17.1464C5.55268 17.2402 5.5 17.3674 5.5 17.5Z" fill="#418997"/>
            </svg>'],
            ['UIデザイナー', 'UI Designer', 'Nhà thiết kế', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.5 5.25H5.5C5.03587 5.25 4.59075 5.43437 4.26256 5.76256C3.93437 6.09075 3.75 6.53587 3.75 7V25C3.75 25.4641 3.93437 25.9092 4.26256 26.2374C4.59075 26.5656 5.03587 26.75 5.5 26.75H27.5C27.9641 26.75 28.4092 26.5656 28.7374 26.2374C29.0656 25.9092 29.25 25.4641 29.25 25V7C29.25 6.53587 29.0656 6.09075 28.7374 5.76256C28.4092 5.43437 27.9641 5.25 27.5 5.25ZM5.5 6.75H27.5C27.5663 6.75 27.6299 6.77634 27.6768 6.82322C27.7237 6.87011 27.75 6.9337 27.75 7V12.25H5.25V7C5.25 6.9337 5.27634 6.87011 5.32322 6.82322C5.37011 6.77634 5.4337 6.75 5.5 6.75ZM5.25 25V13.75H12.75V25.25H5.5C5.4337 25.25 5.37011 25.2237 5.32322 25.1768C5.27634 25.1299 5.25 25.0663 5.25 25ZM27.5 25.25H14.25V13.75H27.75V25C27.75 25.0663 27.7237 25.1299 27.6768 25.1768C27.6299 25.2237 27.5663 25.25 27.5 25.25Z" fill="#4D4D4D"/>
            </svg>'],
            ['AIエンジニア', 'AI Engineer', 'Kĩ sư AI', '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.75 9.00003C13.75 9.19894 13.671 9.38971 13.5303 9.53036C13.3897 9.67101 13.1989 9.75003 13 9.75003H5C4.80109 9.75003 4.61032 9.67101 4.46967 9.53036C4.32902 9.38971 4.25 9.19894 4.25 9.00003C4.25 8.80112 4.32902 8.61035 4.46967 8.4697C4.61032 8.32905 4.80109 8.25003 5 8.25003H13C13.1989 8.25003 13.3897 8.32905 13.5303 8.4697C13.671 8.61035 13.75 8.80112 13.75 9.00003ZM13 22.25H9.75V19C9.75 18.8011 9.67098 18.6104 9.53033 18.4697C9.38968 18.329 9.19891 18.25 9 18.25C8.80109 18.25 8.61032 18.329 8.46967 18.4697C8.32902 18.6104 8.25 18.8011 8.25 19V22.25H5C4.80109 22.25 4.61032 22.329 4.46967 22.4697C4.32902 22.6104 4.25 22.8011 4.25 23C4.25 23.1989 4.32902 23.3897 4.46967 23.5304C4.61032 23.671 4.80109 23.75 5 23.75H8.25V27C8.25 27.1989 8.32902 27.3897 8.46967 27.5304C8.61032 27.671 8.80109 27.75 9 27.75C9.19891 27.75 9.38968 27.671 9.53033 27.5304C9.67098 27.3897 9.75 27.1989 9.75 27V23.75H13C13.1989 23.75 13.3897 23.671 13.5303 23.5304C13.671 23.3897 13.75 23.1989 13.75 23C13.75 22.8011 13.671 22.6104 13.5303 22.4697C13.3897 22.329 13.1989 22.25 13 22.25ZM19 21.75H27C27.1989 21.75 27.3897 21.671 27.5303 21.5304C27.671 21.3897 27.75 21.1989 27.75 21C27.75 20.8011 27.671 20.6104 27.5303 20.4697C27.3897 20.329 27.1989 20.25 27 20.25H19C18.8011 20.25 18.6103 20.329 18.4697 20.4697C18.329 20.6104 18.25 20.8011 18.25 21C18.25 21.1989 18.329 21.3897 18.4697 21.5304C18.6103 21.671 18.8011 21.75 19 21.75ZM27 24.25H19C18.8011 24.25 18.6103 24.329 18.4697 24.4697C18.329 24.6104 18.25 24.8011 18.25 25C18.25 25.1989 18.329 25.3897 18.4697 25.5304C18.6103 25.671 18.8011 25.75 19 25.75H27C27.1989 25.75 27.3897 25.671 27.5303 25.5304C27.671 25.3897 27.75 25.1989 27.75 25C27.75 24.8011 27.671 24.6104 27.5303 24.4697C27.3897 24.329 27.1989 24.25 27 24.25ZM19.47 12.53C19.6106 12.6705 19.8012 12.7494 20 12.7494C20.1988 12.7494 20.3894 12.6705 20.53 12.53L23 10.0613L25.47 12.53C25.6122 12.6625 25.8002 12.7346 25.9945 12.7312C26.1888 12.7278 26.3742 12.6491 26.5116 12.5117C26.649 12.3742 26.7277 12.1889 26.7312 11.9946C26.7346 11.8003 26.6625 11.6122 26.53 11.47L24.0613 9.00003L26.53 6.53003C26.6625 6.38785 26.7346 6.19981 26.7312 6.00551C26.7277 5.81121 26.649 5.62582 26.5116 5.48841C26.3742 5.35099 26.1888 5.27228 25.9945 5.26885C25.8002 5.26543 25.6122 5.33755 25.47 5.47003L23 7.93878L20.53 5.47003C20.3878 5.33755 20.1998 5.26543 20.0055 5.26885C19.8112 5.27228 19.6258 5.35099 19.4884 5.48841C19.351 5.62582 19.2723 5.81121 19.2688 6.00551C19.2654 6.19981 19.3375 6.38785 19.47 6.53003L21.9387 9.00003L19.47 11.47C19.3295 11.6107 19.2507 11.8013 19.2507 12C19.2507 12.1988 19.3295 12.3894 19.47 12.53Z" fill="#4D4D4D"/>
            </svg>'],
            ['CTO', 'CTO', 'Quản lý dự án', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16.25 16C16.2501 16.1126 16.2249 16.2237 16.1762 16.3252C16.1275 16.4267 16.0566 16.5159 15.9688 16.5863L10.9688 20.5863C10.8133 20.7106 10.6148 20.768 10.4169 20.746C10.2191 20.724 10.0381 20.6242 9.91375 20.4688C9.78943 20.3133 9.73197 20.1148 9.754 19.9169C9.77604 19.7191 9.87577 19.5381 10.0312 19.4137L14.3 16L10.0312 12.5863C9.95426 12.5247 9.89015 12.4486 9.84258 12.3622C9.79501 12.2759 9.76491 12.1811 9.754 12.0831C9.74309 11.9851 9.75158 11.886 9.77899 11.7913C9.8064 11.6966 9.85219 11.6082 9.91375 11.5312C9.97531 11.4543 10.0514 11.3902 10.1378 11.3426C10.2241 11.295 10.3189 11.2649 10.4169 11.254C10.5149 11.2431 10.614 11.2516 10.7087 11.279C10.8034 11.3064 10.8918 11.3522 10.9688 11.4137L15.9688 15.4137C16.0566 15.4841 16.1275 15.5733 16.1762 15.6748C16.2249 15.7763 16.2501 15.8874 16.25 16ZM22.5 19.25H17.5C17.3011 19.25 17.1103 19.329 16.9697 19.4697C16.829 19.6103 16.75 19.8011 16.75 20C16.75 20.1989 16.829 20.3897 16.9697 20.5303C17.1103 20.671 17.3011 20.75 17.5 20.75H22.5C22.6989 20.75 22.8897 20.671 23.0303 20.5303C23.171 20.3897 23.25 20.1989 23.25 20C23.25 19.8011 23.171 19.6103 23.0303 19.4697C22.8897 19.329 22.6989 19.25 22.5 19.25ZM29.25 7V25C29.25 25.4641 29.0656 25.9092 28.7374 26.2374C28.4092 26.5656 27.9641 26.75 27.5 26.75H5.5C5.03587 26.75 4.59075 26.5656 4.26256 26.2374C3.93437 25.9092 3.75 25.4641 3.75 25V7C3.75 6.53587 3.93437 6.09075 4.26256 5.76256C4.59075 5.43437 5.03587 5.25 5.5 5.25H27.5C27.9641 5.25 28.4092 5.43437 28.7374 5.76256C29.0656 6.09075 29.25 6.53587 29.25 7ZM27.75 7C27.75 6.9337 27.7237 6.87011 27.6768 6.82322C27.6299 6.77634 27.5663 6.75 27.5 6.75H5.5C5.4337 6.75 5.37011 6.77634 5.32322 6.82322C5.27634 6.87011 5.25 6.9337 5.25 7V25C5.25 25.0663 5.27634 25.1299 5.32322 25.1768C5.37011 25.2237 5.4337 25.25 5.5 25.25H27.5C27.5663 25.25 27.6299 25.2237 27.6768 25.1768C27.7237 25.1299 27.75 25.0663 27.75 25V7Z" fill="#4D4D4D"/>
            </svg>'],
            ['医者', 'Doctor', 'Bác sĩ', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M26.75 19C26.75 19.2472 26.6767 19.4889 26.5393 19.6945C26.402 19.9 26.2068 20.0602 25.9784 20.1549C25.7499 20.2495 25.4986 20.2742 25.2561 20.226C25.0137 20.1777 24.7909 20.0587 24.6161 19.8839C24.4413 19.7091 24.3223 19.4863 24.274 19.2439C24.2258 19.0014 24.2505 18.7501 24.3451 18.5216C24.4398 18.2932 24.6 18.098 24.8055 17.9607C25.0111 17.8233 25.2528 17.75 25.5 17.75C25.8315 17.75 26.1495 17.8817 26.3839 18.1161C26.6183 18.3505 26.75 18.6685 26.75 19ZM26.2062 23.6975C26.0346 25.0906 25.36 26.3729 24.3091 27.3034C23.2582 28.2339 21.9036 28.7483 20.5 28.75H17.5C15.9756 28.748 14.5142 28.1416 13.4363 27.0637C12.3584 25.9858 11.752 24.5244 11.75 23V17.7138C9.83343 17.5274 8.05487 16.6342 6.76084 15.2082C5.4668 13.7823 4.74997 11.9256 4.75 10V5C4.75 4.53587 4.93437 4.09075 5.26256 3.76256C5.59075 3.43437 6.03587 3.25 6.5 3.25H8.5C8.69891 3.25 8.88968 3.32902 9.03033 3.46967C9.17098 3.61032 9.25 3.80109 9.25 4C9.25 4.19891 9.17098 4.38968 9.03033 4.53033C8.88968 4.67098 8.69891 4.75 8.5 4.75H6.5C6.4337 4.75 6.37011 4.77634 6.32322 4.82322C6.27634 4.87011 6.25 4.9337 6.25 5V10C6.25 11.6576 6.90848 13.2473 8.08058 14.4194C9.25269 15.5915 10.8424 16.25 12.5 16.25H12.5837C15.9837 16.205 18.75 13.355 18.75 9.89625V5C18.75 4.9337 18.7237 4.87011 18.6768 4.82322C18.6299 4.77634 18.5663 4.75 18.5 4.75H16.5C16.3011 4.75 16.1103 4.67098 15.9697 4.53033C15.829 4.38968 15.75 4.19891 15.75 4C15.75 3.80109 15.829 3.61032 15.9697 3.46967C16.1103 3.32902 16.3011 3.25 16.5 3.25H18.5C18.9641 3.25 19.4092 3.43437 19.7374 3.76256C20.0656 4.09075 20.25 4.53587 20.25 5V9.89625C20.25 13.95 17.165 17.3263 13.25 17.7113V23C13.25 24.1272 13.6978 25.2082 14.4948 26.0052C15.2918 26.8022 16.3728 27.25 17.5 27.25H20.5C21.5089 27.2487 22.4846 26.889 23.2529 26.2351C24.0212 25.5813 24.5323 24.6757 24.695 23.68C23.5183 23.4764 22.4615 22.837 21.735 21.8893C21.0086 20.9415 20.6657 19.7549 20.7748 18.5657C20.8839 17.3765 21.4368 16.2721 22.3236 15.4723C23.2104 14.6725 24.3658 14.2361 25.5599 14.2499C26.754 14.2637 27.8991 14.7268 28.7671 15.5469C29.6351 16.367 30.1623 17.484 30.2438 18.6754C30.3254 19.8667 29.9551 21.0451 29.2069 21.9758C28.4587 22.9065 27.3873 23.5212 26.2062 23.6975ZM28.75 19C28.75 18.3572 28.5594 17.7289 28.2023 17.1944C27.8452 16.6599 27.3376 16.2434 26.7437 15.9974C26.1499 15.7514 25.4964 15.687 24.866 15.8124C24.2355 15.9378 23.6564 16.2474 23.2019 16.7019C22.7474 17.1564 22.4379 17.7355 22.3124 18.366C22.187 18.9964 22.2514 19.6499 22.4974 20.2437C22.7434 20.8376 23.1599 21.3452 23.6944 21.7023C24.2289 22.0594 24.8572 22.25 25.5 22.25C25.9268 22.25 26.3494 22.1659 26.7437 22.0026C27.138 21.8393 27.4963 21.5999 27.7981 21.2981C28.0999 20.9963 28.3393 20.638 28.5026 20.2437C28.6659 19.8494 28.75 19.4268 28.75 19Z" fill="#4D4D4D"/>
            </svg>'],
            ['歯医者', 'Dentist', 'Nha sĩ', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.7787 8.69625L18.52 10L21.7787 11.3038C21.8709 11.3398 21.9551 11.3938 22.0263 11.4625C22.0975 11.5313 22.1544 11.6134 22.1937 11.7043C22.2331 11.7951 22.254 11.8928 22.2554 11.9918C22.2567 12.0908 22.2385 12.189 22.2017 12.2809C22.1649 12.3728 22.1103 12.4565 22.041 12.5272C21.9717 12.5979 21.8891 12.6542 21.798 12.6928C21.7068 12.7314 21.6089 12.7516 21.51 12.7522C21.411 12.7528 21.3129 12.7338 21.2213 12.6962L16.5 10.8075L11.7788 12.6962C11.6872 12.7328 11.5894 12.751 11.4909 12.7497C11.3923 12.7485 11.295 12.7278 11.2045 12.6889C11.1139 12.65 11.0319 12.5937 10.9632 12.5231C10.8944 12.4525 10.8402 12.369 10.8038 12.2775C10.7302 12.093 10.7329 11.8868 10.8111 11.7043C10.8894 11.5217 11.0369 11.3777 11.2212 11.3038L14.48 10L11.2212 8.69625C11.0381 8.62126 10.892 8.47693 10.8148 8.29471C10.7377 8.11249 10.7356 7.90714 10.8092 7.72342C10.8827 7.5397 11.0259 7.3925 11.2075 7.31389C11.3891 7.23528 11.5945 7.23163 11.7788 7.30375L16.5 9.19125L21.2213 7.30375C21.3129 7.26624 21.411 7.24724 21.51 7.24783C21.6089 7.24843 21.7068 7.26861 21.798 7.30722C21.8891 7.34583 21.9717 7.4021 22.041 7.47278C22.1103 7.54347 22.1649 7.62717 22.2017 7.71906C22.2385 7.81096 22.2567 7.90922 22.2554 8.0082C22.254 8.10717 22.2331 8.2049 22.1937 8.29574C22.1544 8.38658 22.0975 8.46874 22.0263 8.53748C21.9551 8.60622 21.8709 8.66018 21.7787 8.69625ZM28.25 9.96875C28.25 15.275 27.2612 19.3312 26.4263 21.7987C25.3525 24.975 23.8988 27.3913 22.4375 28.4237C22.1877 28.6036 21.894 28.7128 21.5874 28.7399C21.2807 28.767 20.9725 28.7109 20.695 28.5775C20.4142 28.4438 20.1738 28.2382 19.9982 27.9816C19.8225 27.7249 19.7179 27.4264 19.695 27.1162C19.5538 25.2 18.9612 20.7412 16.505 20.7412C14.0487 20.7412 13.4562 25.1962 13.315 27.1162C13.2805 27.5573 13.0814 27.9693 12.7572 28.2703C12.433 28.5714 12.0074 28.7395 11.565 28.7412C11.2061 28.7413 10.8563 28.6285 10.565 28.4188C9.10375 27.3825 7.65 24.9663 6.57625 21.7938C5.73875 19.3313 4.75 15.275 4.75 9.96875C4.75826 8.18396 5.47307 6.47509 6.73804 5.21597C8.00302 3.95685 9.71519 3.24998 11.5 3.25H21.5C23.2848 3.24998 24.997 3.95685 26.262 5.21597C27.5269 6.47509 28.2417 8.18396 28.25 9.96875ZM26.75 9.96875C26.7417 8.58179 26.185 7.25444 25.2013 6.27662C24.2176 5.29881 22.887 4.74998 21.5 4.75H11.5C10.1128 4.74998 8.78196 5.29898 7.79826 6.27707C6.81455 7.25515 6.25793 8.58282 6.25 9.97C6.24125 19.2113 9.33625 25.72 11.43 27.205C11.4634 27.23 11.5032 27.245 11.5448 27.2483C11.5864 27.2516 11.628 27.2431 11.665 27.2237C11.707 27.2052 11.7432 27.1755 11.7694 27.1378C11.7956 27.1001 11.811 27.0559 11.8138 27.01C12.1825 22 13.8463 19.25 16.5 19.25C19.1537 19.25 20.8175 22 21.1863 27.0112C21.189 27.0571 21.2044 27.1013 21.2306 27.139C21.2568 27.1767 21.293 27.2065 21.335 27.225C21.372 27.2443 21.4136 27.2528 21.4552 27.2495C21.4968 27.2462 21.5366 27.2312 21.57 27.2062C23.6637 25.7175 26.7588 19.2113 26.75 9.97V9.96875Z" fill="#4D4D4D"/>
            </svg>'],
            ['プロゲーマー', 'Pro Gamer', 'Game thủ chuyên nghiệp', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.5001 13.75H19.5001C19.3012 13.75 19.1104 13.671 18.9698 13.5303C18.8291 13.3897 18.7501 13.1989 18.7501 13C18.7501 12.8011 18.8291 12.6103 18.9698 12.4697C19.1104 12.329 19.3012 12.25 19.5001 12.25H22.5001C22.699 12.25 22.8898 12.329 23.0305 12.4697C23.1711 12.6103 23.2501 12.8011 23.2501 13C23.2501 13.1989 23.1711 13.3897 23.0305 13.5303C22.8898 13.671 22.699 13.75 22.5001 13.75ZM13.5001 12.25H12.2501V11C12.2501 10.8011 12.1711 10.6103 12.0305 10.4697C11.8898 10.329 11.699 10.25 11.5001 10.25C11.3012 10.25 11.1105 10.329 10.9698 10.4697C10.8291 10.6103 10.7501 10.8011 10.7501 11V12.25H9.50013C9.30122 12.25 9.11045 12.329 8.9698 12.4697C8.82915 12.6103 8.75013 12.8011 8.75013 13C8.75013 13.1989 8.82915 13.3897 8.9698 13.5303C9.11045 13.671 9.30122 13.75 9.50013 13.75H10.7501V15C10.7501 15.1989 10.8291 15.3897 10.9698 15.5303C11.1105 15.671 11.3012 15.75 11.5001 15.75C11.699 15.75 11.8898 15.671 12.0305 15.5303C12.1711 15.3897 12.2501 15.1989 12.2501 15V13.75H13.5001C13.699 13.75 13.8898 13.671 14.0305 13.5303C14.1711 13.3897 14.2501 13.1989 14.2501 13C14.2501 12.8011 14.1711 12.6103 14.0305 12.4697C13.8898 12.329 13.699 12.25 13.5001 12.25ZM30.4801 24.9375C30.0884 25.497 29.5676 25.9539 28.9618 26.2694C28.356 26.5849 27.6831 26.7498 27.0001 26.75C25.8752 26.7474 24.7969 26.3004 24.0001 25.5063L23.9676 25.4713L18.9226 19.75H14.0776L9.03888 25.47L9.00013 25.5C8.20523 26.2977 7.12624 26.7472 6.00013 26.75C5.3797 26.7496 4.76688 26.6133 4.20473 26.3508C3.64257 26.0883 3.1447 25.7059 2.7461 25.2305C2.34749 24.755 2.05782 24.1981 1.89742 23.5988C1.73702 22.9994 1.70978 22.3722 1.81763 21.7612C1.81763 21.7612 1.81763 21.7537 1.81763 21.7488L3.86263 11.235C4.15686 9.55904 5.03228 8.04038 6.3351 6.94582C7.63792 5.85126 9.28479 5.25082 10.9864 5.25H22.0001C23.6973 5.25216 25.3401 5.84896 26.6429 6.93666C27.9458 8.02437 28.8263 9.53421 29.1314 11.2037C29.1314 11.2125 29.1314 11.2188 29.1314 11.2275L31.1826 21.75C31.1826 21.75 31.1826 21.7588 31.1826 21.7638C31.2812 22.3129 31.2699 22.8762 31.1493 23.421C31.0287 23.9658 30.8013 24.4812 30.4801 24.9375ZM22.0001 18.25C23.5251 18.25 24.9877 17.6442 26.066 16.5659C27.1443 15.4875 27.7501 14.025 27.7501 12.5C27.7501 10.975 27.1443 9.51247 26.066 8.43414C24.9877 7.3558 23.5251 6.75 22.0001 6.75H10.9864C9.63669 6.75103 8.33057 7.22784 7.29766 8.0966C6.26475 8.96536 5.57118 10.1705 5.33888 11.5C5.3383 11.5041 5.3383 11.5084 5.33888 11.5125L3.29138 22.0287C3.19144 22.6027 3.27632 23.1935 3.53379 23.716C3.79127 24.2386 4.20803 24.6659 4.724 24.9363C5.23996 25.2067 5.82847 25.3063 6.40469 25.2207C6.98091 25.1351 7.51505 24.8687 7.93013 24.46L13.1801 18.5037C13.2509 18.4247 13.3376 18.3615 13.4345 18.3184C13.5315 18.2753 13.6365 18.2533 13.7426 18.2537L22.0001 18.25ZM29.7089 22.0287L28.4851 15.735C27.8833 16.9401 26.9579 17.954 25.8126 18.6631C24.6673 19.3722 23.3472 19.7485 22.0001 19.75H20.9214L25.0701 24.46C25.4852 24.8687 26.0194 25.1351 26.5956 25.2207C27.1718 25.3063 27.7603 25.2067 28.2763 24.9363C28.7922 24.6659 29.209 24.2386 29.4665 23.716C29.7239 23.1935 29.8088 22.6027 29.7089 22.0287Z" fill="#4D4D4D"/>
            </svg>'],
            ['俳優', 'Actor', 'Diễn viên', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.5 12.25H11.5C10.2402 12.25 9.03204 12.7504 8.14124 13.6412C7.25045 14.532 6.75 15.7402 6.75 17V18C6.75 19.2598 7.25045 20.468 8.14124 21.3587C9.03204 22.2495 10.2402 22.75 11.5 22.75H21.5C22.7598 22.75 23.968 22.2495 24.8588 21.3587C25.7496 20.468 26.25 19.2598 26.25 18V17C26.25 15.7402 25.7496 14.532 24.8588 13.6412C23.968 12.7504 22.7598 12.25 21.5 12.25ZM24.75 18C24.75 18.8619 24.4076 19.6886 23.7981 20.2981C23.1886 20.9076 22.362 21.25 21.5 21.25H11.5C10.638 21.25 9.8114 20.9076 9.20191 20.2981C8.59241 19.6886 8.25 18.8619 8.25 18V17C8.25 16.138 8.59241 15.3114 9.20191 14.7019C9.8114 14.0924 10.638 13.75 11.5 13.75H21.5C22.362 13.75 23.1886 14.0924 23.7981 14.7019C24.4076 15.3114 24.75 16.138 24.75 17V18ZM26.5 4.24999C25.6358 4.25099 24.7984 4.54993 24.129 5.09642C23.4595 5.64291 22.999 6.40351 22.825 7.24999H10.175C9.98994 6.33863 9.47285 5.52854 8.72411 4.97698C7.97536 4.42542 7.04839 4.17175 6.12313 4.26521C5.19787 4.35867 4.34035 4.79259 3.71703 5.48274C3.09371 6.17289 2.74907 7.07003 2.75 7.99999V18C2.75265 20.3198 3.67537 22.5439 5.31574 24.1843C6.95611 25.8246 9.18017 26.7473 11.5 26.75H21.5C23.8198 26.7473 26.0439 25.8246 27.6843 24.1843C29.3246 22.5439 30.2474 20.3198 30.25 18V7.99999C30.25 7.00543 29.8549 6.0516 29.1517 5.34834C28.4484 4.64508 27.4946 4.24999 26.5 4.24999ZM28.75 18C28.7477 19.9221 27.9831 21.7648 26.624 23.124C25.2648 24.4831 23.4221 25.2477 21.5 25.25H11.5C9.57789 25.2477 7.73517 24.4831 6.37604 23.124C5.0169 21.7648 4.25232 19.9221 4.25 18V7.99999C4.25 7.40326 4.48706 6.83096 4.90901 6.409C5.33097 5.98705 5.90326 5.74999 6.5 5.74999C7.09674 5.74999 7.66903 5.98705 8.09099 6.409C8.51295 6.83096 8.75 7.40326 8.75 7.99999C8.75 8.19891 8.82902 8.38967 8.96967 8.53032C9.11032 8.67097 9.30109 8.74999 9.5 8.74999H23.5C23.6989 8.74999 23.8897 8.67097 24.0303 8.53032C24.171 8.38967 24.25 8.19891 24.25 7.99999C24.25 7.40326 24.4871 6.83096 24.909 6.409C25.331 5.98705 25.9033 5.74999 26.5 5.74999C27.0967 5.74999 27.669 5.98705 28.091 6.409C28.5129 6.83096 28.75 7.40326 28.75 7.99999V18ZM13.25 17.5C13.25 17.7472 13.1767 17.9889 13.0393 18.1945C12.902 18.4 12.7068 18.5602 12.4784 18.6548C12.2499 18.7495 11.9986 18.7742 11.7561 18.726C11.5137 18.6777 11.2909 18.5587 11.1161 18.3839C10.9413 18.2091 10.8223 17.9863 10.774 17.7439C10.7258 17.5014 10.7505 17.25 10.8452 17.0216C10.9398 16.7932 11.1 16.598 11.3055 16.4607C11.5111 16.3233 11.7528 16.25 12 16.25C12.3315 16.25 12.6495 16.3817 12.8839 16.6161C13.1183 16.8505 13.25 17.1685 13.25 17.5ZM22.25 17.5C22.25 17.7472 22.1767 17.9889 22.0393 18.1945C21.902 18.4 21.7068 18.5602 21.4784 18.6548C21.2499 18.7495 20.9986 18.7742 20.7561 18.726C20.5137 18.6777 20.2909 18.5587 20.1161 18.3839C19.9413 18.2091 19.8223 17.9863 19.774 17.7439C19.7258 17.5014 19.7505 17.25 19.8452 17.0216C19.9398 16.7932 20.1 16.598 20.3055 16.4607C20.5111 16.3233 20.7528 16.25 21 16.25C21.3315 16.25 21.6495 16.3817 21.8839 16.6161C22.1183 16.8505 22.25 17.1685 22.25 17.5Z" fill="#4D4D4D"/>
            </svg>'],
            ['歌手', 'Singer', 'Ca sĩ', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 2C18.6138 2.00232 16.3259 2.95127 14.6386 4.6386C12.9513 6.32592 12.0023 8.61376 12 11C12.0009 11.3938 12.0272 11.7871 12.0788 12.1775L3.39001 24.0275C3.10561 24.4121 2.96919 24.8863 3.00568 25.3633C3.04218 25.8402 3.24916 26.2881 3.58876 26.625L5.37501 28.4112C5.7119 28.7509 6.15978 28.9578 6.63675 28.9943C7.11371 29.0308 7.58787 28.8944 7.97251 28.61L19.8238 19.9188C20.2137 19.9711 20.6066 19.9982 21 20C23.387 20 25.6761 19.0518 27.364 17.364C29.0518 15.6761 30 13.3869 30 11C30 8.61305 29.0518 6.32387 27.364 4.63604C25.6761 2.94821 23.387 2 21 2ZM28 11C28.0018 12.511 27.5122 13.9816 26.605 15.19L16.8113 5.395C17.8516 4.61799 19.0876 4.14566 20.381 4.03084C21.6744 3.91602 22.9743 4.16322 24.1353 4.74481C25.2962 5.3264 26.2726 6.21945 26.9551 7.32411C27.6376 8.42877 27.9994 9.7015 28 11ZM6.79001 27L5.00001 25.21L12.7675 14.625C13.6777 16.6798 15.3202 18.3223 17.375 19.2325L6.79001 27ZM14 11C13.998 9.48934 14.4877 8.01907 15.395 6.81125L25.1875 16.6038C24.1472 17.3803 22.9115 17.8524 21.6184 17.967C20.3253 18.0817 19.0258 17.8345 17.865 17.2531C16.7043 16.6718 15.7281 15.779 15.0456 14.6748C14.3631 13.5705 14.001 12.2982 14 11ZM13.7063 18.2925C13.8937 18.48 13.9989 18.7343 13.9989 18.9994C13.9989 19.2645 13.8937 19.5187 13.7063 19.7062L12.7063 20.7062C12.6143 20.803 12.5039 20.8804 12.3816 20.9338C12.2593 20.9873 12.1275 21.0157 11.9941 21.0174C11.8606 21.0191 11.7282 20.9941 11.6045 20.9438C11.4809 20.8935 11.3686 20.819 11.2742 20.7246C11.1798 20.6302 11.1053 20.5179 11.055 20.3942C11.0047 20.2706 10.9797 20.1381 10.9814 20.0047C10.9831 19.8712 11.0115 19.7394 11.0649 19.6171C11.1184 19.4948 11.1957 19.3844 11.2925 19.2925L12.2925 18.2925C12.3853 18.1993 12.4956 18.1252 12.6171 18.0747C12.7386 18.0242 12.8688 17.9981 13.0004 17.998C13.1319 17.9978 13.2622 18.0237 13.3838 18.074C13.5053 18.1243 13.6158 18.1982 13.7088 18.2913L13.7063 18.2925Z" fill="#343330"/>
            </svg>'],
            ['教授', 'Professor', 'Giáo sư', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 22.0005C17.9778 22.0005 19.9112 21.414 21.5557 20.3152C23.2002 19.2164 24.4819 17.6546 25.2388 15.8273C25.9957 14.0001 26.1937 11.9894 25.8078 10.0496C25.422 8.10977 24.4696 6.32794 23.0711 4.92942C21.6725 3.53089 19.8907 2.57848 17.9509 2.19263C16.0111 1.80678 14.0004 2.00481 12.1732 2.76169C10.3459 3.51856 8.78411 4.80029 7.6853 6.44478C6.58649 8.08927 6 10.0227 6 12.0005C6.00297 14.6517 7.0575 17.1935 8.93222 19.0683C10.8069 20.943 13.3487 21.9975 16 22.0005ZM16 4.00048C17.5822 4.00048 19.129 4.46968 20.4446 5.34873C21.7602 6.22778 22.7855 7.47721 23.391 8.93902C23.9965 10.4008 24.155 12.0094 23.8463 13.5612C23.5376 15.1131 22.7757 16.5385 21.6569 17.6573C20.538 18.7762 19.1126 19.5381 17.5607 19.8468C16.0089 20.1554 14.4003 19.997 12.9385 19.3915C11.4767 18.786 10.2273 17.7606 9.34824 16.445C8.46919 15.1295 8 13.5827 8 12.0005C8.00231 9.87946 8.84591 7.84598 10.3457 6.34619C11.8455 4.8464 13.879 4.0028 16 4.00048ZM25.7212 20.688C25.8124 20.7827 25.8839 20.8945 25.9318 21.0169C25.9796 21.1394 26.0029 21.27 26.0002 21.4014C25.9976 21.5329 25.969 21.6625 25.9162 21.7829C25.8634 21.9032 25.7874 22.012 25.6925 22.103C23.3392 24.3723 20.2615 25.7399 17 25.9655V28.0005H20C20.2652 28.0005 20.5196 28.1058 20.7071 28.2934C20.8946 28.4809 21 28.7353 21 29.0005C21 29.2657 20.8946 29.5201 20.7071 29.7076C20.5196 29.8951 20.2652 30.0005 20 30.0005H12C11.7348 30.0005 11.4804 29.8951 11.2929 29.7076C11.1054 29.5201 11 29.2657 11 29.0005C11 28.7353 11.1054 28.4809 11.2929 28.2934C11.4804 28.1058 11.7348 28.0005 12 28.0005H15V25.9642C12.3478 25.7743 9.80445 24.8329 7.66767 23.2503C5.53089 21.6677 3.88899 19.5093 2.93409 17.0276C1.97919 14.5459 1.75078 11.8437 2.27558 9.23692C2.80037 6.63018 4.05668 4.2268 5.8975 2.30798C5.98786 2.21089 6.09663 2.13275 6.21747 2.0781C6.33832 2.02345 6.46884 1.99338 6.60141 1.98965C6.73399 1.98592 6.86599 2.00861 6.98972 2.05638C7.11345 2.10415 7.22644 2.17606 7.32211 2.26792C7.41778 2.35978 7.49422 2.46975 7.54699 2.59144C7.59975 2.71312 7.62778 2.84409 7.62945 2.97671C7.63111 3.10933 7.60638 3.24095 7.55668 3.36393C7.50699 3.4869 7.43333 3.59875 7.34 3.69298C5.1601 5.95732 3.95563 8.98655 3.98549 12.1295C4.01535 15.2725 5.27715 18.2783 7.49967 20.5008C9.72219 22.7233 12.728 23.9851 15.871 24.015C19.0139 24.0448 22.0432 22.8404 24.3075 20.6605C24.4986 20.4767 24.7549 20.3763 25.0201 20.3815C25.2852 20.3867 25.5374 20.4969 25.7212 20.688Z" fill="#343330"/>
            </svg>'],
            ['画家', 'Artist', 'Nghệ sĩ', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M26 4H6C5.46957 4 4.96086 4.21071 4.58579 4.58579C4.21071 4.96086 4 5.46957 4 6V26C4 26.5304 4.21071 27.0391 4.58579 27.4142C4.96086 27.7893 5.46957 28 6 28H26C26.5304 28 27.0391 27.7893 27.4142 27.4142C27.7893 27.0391 28 26.5304 28 26V6C28 5.46957 27.7893 4.96086 27.4142 4.58579C27.0391 4.21071 26.5304 4 26 4ZM10 6H13V17H10V6ZM14 19C14.2652 19 14.5196 18.8946 14.7071 18.7071C14.8946 18.5196 15 18.2652 15 18V6H17V18C17 18.2652 17.1054 18.5196 17.2929 18.7071C17.4804 18.8946 17.7348 19 18 19H19V26H13V19H14ZM19 17V6H22V17H19ZM6 6H8V18C8 18.2652 8.10536 18.5196 8.29289 18.7071C8.48043 18.8946 8.73478 19 9 19H11V26H6V6ZM26 26H21V19H23C23.2652 19 23.5196 18.8946 23.7071 18.7071C23.8946 18.5196 24 18.2652 24 18V6H26V26Z" fill="#343330"/>
            </svg>'],
            ['MC', 'MC', 'MC', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27 5H5C4.46957 5 3.96086 5.21071 3.58579 5.58579C3.21071 5.96086 3 6.46957 3 7V27C3.00009 27.1704 3.04374 27.338 3.12681 27.4869C3.20988 27.6357 3.32961 27.7608 3.47463 27.8503C3.61965 27.9399 3.78516 27.9909 3.95543 27.9985C4.12569 28.0061 4.29508 27.97 4.4475 27.8937L8 26.1175L11.5525 27.8937C11.6914 27.9633 11.8446 27.9995 12 27.9995C12.1554 27.9995 12.3086 27.9633 12.4475 27.8937L16 26.1175L19.5525 27.8937C19.6914 27.9633 19.8446 27.9995 20 27.9995C20.1554 27.9995 20.3086 27.9633 20.4475 27.8937L24 26.1175L27.5525 27.8937C27.7049 27.97 27.8743 28.0061 28.0446 27.9985C28.2148 27.9909 28.3803 27.9399 28.5254 27.8503C28.6704 27.7608 28.7901 27.6357 28.8732 27.4869C28.9563 27.338 28.9999 27.1704 29 27V7C29 6.46957 28.7893 5.96086 28.4142 5.58579C28.0391 5.21071 27.5304 5 27 5ZM27 25.3825L24.4475 24.105C24.3086 24.0355 24.1554 23.9993 24 23.9993C23.8446 23.9993 23.6914 24.0355 23.5525 24.105L20 25.8825L16.4475 24.105C16.3086 24.0355 16.1554 23.9993 16 23.9993C15.8446 23.9993 15.6914 24.0355 15.5525 24.105L12 25.8825L8.4475 24.105C8.30857 24.0355 8.15535 23.9993 8 23.9993C7.84465 23.9993 7.69143 24.0355 7.5525 24.105L5 25.3825V7H27V25.3825ZM17 14C17 13.7348 17.1054 13.4804 17.2929 13.2929C17.4804 13.1054 17.7348 13 18 13H24C24.2652 13 24.5196 13.1054 24.7071 13.2929C24.8946 13.4804 25 13.7348 25 14C25 14.2652 24.8946 14.5196 24.7071 14.7071C24.5196 14.8946 24.2652 15 24 15H18C17.7348 15 17.4804 14.8946 17.2929 14.7071C17.1054 14.5196 17 14.2652 17 14ZM17 18C17 17.7348 17.1054 17.4804 17.2929 17.2929C17.4804 17.1054 17.7348 17 18 17H24C24.2652 17 24.5196 17.1054 24.7071 17.2929C24.8946 17.4804 25 17.7348 25 18C25 18.2652 24.8946 18.5196 24.7071 18.7071C24.5196 18.8946 24.2652 19 24 19H18C17.7348 19 17.4804 18.8946 17.2929 18.7071C17.1054 18.5196 17 18.2652 17 18ZM8 21H14C14.2652 21 14.5196 20.8946 14.7071 20.7071C14.8946 20.5196 15 20.2652 15 20V12C15 11.7348 14.8946 11.4804 14.7071 11.2929C14.5196 11.1054 14.2652 11 14 11H8C7.73478 11 7.48043 11.1054 7.29289 11.2929C7.10536 11.4804 7 11.7348 7 12V20C7 20.2652 7.10536 20.5196 7.29289 20.7071C7.48043 20.8946 7.73478 21 8 21ZM9 13H13V19H9V13Z" fill="#343330"/>
            </svg>'],
            ['運転者', 'Driver', 'Lái xe', '<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M31.7588 14.3488L26.0662 7.71625C25.8785 7.49198 25.6439 7.31161 25.3789 7.18786C25.1139 7.06411 24.825 6.99998 24.5325 7H4C3.46957 7 2.96086 7.21071 2.58579 7.58579C2.21071 7.96086 2 8.46957 2 9V23C2 23.5304 2.21071 24.0391 2.58579 24.4142C2.96086 24.7893 3.46957 25 4 25H6.125C6.3453 25.8604 6.8457 26.623 7.54731 27.1676C8.24892 27.7122 9.11183 28.0078 10 28.0078C10.8882 28.0078 11.7511 27.7122 12.4527 27.1676C13.1543 26.623 13.6547 25.8604 13.875 25H20.125C20.3453 25.8604 20.8457 26.623 21.5473 27.1676C22.2489 27.7122 23.1118 28.0078 24 28.0078C24.8882 28.0078 25.7511 27.7122 26.4527 27.1676C27.1543 26.623 27.6547 25.8604 27.875 25H30C30.5304 25 31.0391 24.7893 31.4142 24.4142C31.7893 24.0391 32 23.5304 32 23V15C32 14.7611 31.9144 14.53 31.7588 14.3488ZM28.8237 14H22V9H24.5325L28.8237 14ZM13 14V9H20V14H13ZM11 9V14H4V9H11ZM10 26C9.60444 26 9.21776 25.8827 8.88886 25.6629C8.55996 25.4432 8.30362 25.1308 8.15224 24.7654C8.00087 24.3999 7.96126 23.9978 8.03843 23.6098C8.1156 23.2219 8.30608 22.8655 8.58579 22.5858C8.86549 22.3061 9.22186 22.1156 9.60982 22.0384C9.99778 21.9613 10.3999 22.0009 10.7654 22.1522C11.1308 22.3036 11.4432 22.56 11.6629 22.8889C11.8827 23.2178 12 23.6044 12 24C12 24.5304 11.7893 25.0391 11.4142 25.4142C11.0391 25.7893 10.5304 26 10 26ZM24 26C23.6044 26 23.2178 25.8827 22.8889 25.6629C22.56 25.4432 22.3036 25.1308 22.1522 24.7654C22.0009 24.3999 21.9613 23.9978 22.0384 23.6098C22.1156 23.2219 22.3061 22.8655 22.5858 22.5858C22.8655 22.3061 23.2219 22.1156 23.6098 22.0384C23.9978 21.9613 24.3999 22.0009 24.7654 22.1522C25.1308 22.3036 25.4432 22.56 25.6629 22.8889C25.8827 23.2178 26 23.6044 26 24C26 24.5304 25.7893 25.0391 25.4142 25.4142C25.0391 25.7893 24.5304 26 24 26ZM27.875 23C27.6547 22.1396 27.1543 21.377 26.4527 20.8324C25.7511 20.2878 24.8882 19.9922 24 19.9922C23.1118 19.9922 22.2489 20.2878 21.5473 20.8324C20.8457 21.377 20.3453 22.1396 20.125 23H13.875C13.6547 22.1396 13.1543 21.377 12.4527 20.8324C11.7511 20.2878 10.8882 19.9922 10 19.9922C9.11183 19.9922 8.24892 20.2878 7.54731 20.8324C6.8457 21.377 6.3453 22.1396 6.125 23H4V16H30V23H27.875Z" fill="#343330"/>
            </svg>'],
            ['機長', 'Pilot', 'Phi công', '<svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" fill="#000000" viewBox="0 0 33 32">
            <path d="M235.58,128.84,160,91.06V48a32,32,0,0,0-64,0V91.06L20.42,128.84A8,8,0,0,0,16,136v32a8,8,0,0,0,9.57,7.84L96,161.76v18.93L82.34,194.34A8,8,0,0,0,80,200v32a8,8,0,0,0,11,7.43l37-14.81,37,14.81A8,8,0,0,0,176,232V200a8,8,0,0,0-2.34-5.66L160,180.69V161.76l70.43,14.08A8,8,0,0,0,240,168V136A8,8,0,0,0,235.58,128.84ZM224,158.24l-70.43-14.08A8,8,0,0,0,144,152v32a8,8,0,0,0,2.34,5.66L160,203.31v16.87l-29-11.61a8,8,0,0,0-5.94,0L96,220.18V203.31l13.66-13.65A8,8,0,0,0,112,184V152a8,8,0,0,0-9.57-7.84L32,158.24v-17.3l75.58-37.78A8,8,0,0,0,112,96V48a16,16,0,0,1,32,0V96a8,8,0,0,0,4.42,7.16L224,140.94Z"></path>
            </svg>'],
            ['船員', 'Sailor', 'Thủy thủ', '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
            <path d="M216,136a8,8,0,0,0-8,8,40,40,0,0,1-40,40,47.79,47.79,0,0,0-32,12.27V128h32a8,8,0,0,0,0-16H136V87a32,32,0,1,0-16,0v25H88a8,8,0,0,0,0,16h32v68.27A47.79,47.79,0,0,0,88,184a40,40,0,0,1-40-40,8,8,0,0,0-16,0,56.06,56.06,0,0,0,56,56,32,32,0,0,1,32,32,8,8,0,0,0,16,0,32,32,0,0,1,32-32,56.06,56.06,0,0,0,56-56A8,8,0,0,0,216,136ZM112,56a16,16,0,1,1,16,16A16,16,0,0,1,112,56Z"></path>
            </svg>'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name_jp'       => $category[0],
                'name_en'       => $category[1],
                'name_vn'       => $category[2],
                'icon'    => $category[3],
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}