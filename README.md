1. Link git: ```https://github.com/mockingbitch/rental-house```
2. Setup clone code: 
 - Tạo folder rentalhouse trong folder laragon/www
 - Trong folder vừa tạo mở cmd / git bash. Chạy command: ```git init``` để sinh folder ẩn .git
 - Trong view hidden file ở menu công cụ. Sau đó mở file .git vừa tạo
 - Mở file config bằng notepad hoặc vscode và paste toàn bộ đoạn sau vào:


[core]
	repositoryformatversion = 0
	filemode = false
	bare = false
	logallrefupdates = true
	symlinks = false
	ignorecase = true
[remote "origin"]
	url = https://oauth:xxxx@github.com/mockingbitch/rentalhouse
	fetch = +refs/heads/*:refs/remotes/origin/*
[branch "master"]
	remote = origin
	merge = refs/heads/master
[branch "dev"]
	remote = origin
	merge = refs/heads/dev
[user]
	email = jarvis.phongtran@gmail.com
	name = Thor



 - Quay lại folder rentalhouse. Mở terminal lên và chạy command: ```git clone https://github.com/mockingbitch/rental-house```

3. Setup project:
- chạy command ```git fetch --all```
- checkout sang dev
- chạy ```composer install``` và ```npm install```
- chạy command ```cp .env.example .env```
- Sửa lại config db trong .env
- Chạy ```php artisan key:generate``` và ```php artisan migrate```
- Để chạy project, mở 2 tab terminal:
 + Tab 1: ```php artisan ser```
 + Tab 2: ```npm run dev```
- Check địa chỉ: 127.0.0.1:8000