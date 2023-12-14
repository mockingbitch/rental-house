1. Run command `docker compose build` ở terminal
2. Comment dòng `command: [ "php", "artisan", "octane:start", "--host=0.0.0.0", "--port=1215" ]`
3. Run command `docker compose up`
4. Mở tab terminal khác và run `docker ps -a`
5. Tìm dòng rental_house_worker và check 3 ký tự đầu trong cột CONTAINER ID
   VD: `c80`4e35f8968 - rental_house_worker
   \*Lưu ý: container id sẽ thay đổi mỗi khi chạy lại `docker compose up`
6. RUN CMD `docker exec -it c80 bash`
7. Khi đã execute được container.
   Run command
   `composer update`
   `cp .env.example .env`
   `php artisan key:generate`
   `php artisan octane:install`
   Sau đó chọn option `1`: Swoole
8. Run command `php artisan setup` để migrate db và tạo account admin. Tài khoản admin được config trong .env
9. Đóng terminal chạy `docker compose up`
10. Mở comment ở bước 2.
11. Chạy lại command `docker compose up`
12. Mở Browser và chạy localhost:81
