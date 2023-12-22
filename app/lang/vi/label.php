<?php

return [
    'user' => [
        'field'   => [
            'email'                 => 'Email',
            'password'              => 'Mật khẩu',
            'password_confirmation' => 'Xác nhận mật khẩu',
            'firstName'             => 'Họ',
            'lastName'              => 'Tên',
            'birthday'              => 'Sinh nhật',
            'province'              => 'Tỉnh',
            'district'              => 'Quận',
            'ward'                  => 'Phường',
            'address'               => 'Địa chỉ',
        ],
    ],
    'login' => [
        'title'     => 'Đăng nhập',
        'hint'      => 'Hint hint hint hint',
        'note'      => 'Note note note note',
        'button'    => 'Đăng nhập',
    ],
    'register' => [
        'title'                 => 'Đăng lý',
        'note_email'            => '(Giả định) Sau khi hoàn tất đăng ký tài khoản, bạn có thể thay đổi email của mình',
        'note_password'         => 'Hint display area',
        'hint_password'         => 'Attention trouble display area',
        'term_of_service'       => 'Chính sách dịch vụ',
        'privacy_policy'        => 'Chính sách bảo mật',
        'and'                   => 'và',
        'term'                  => 'Vui lòng đồng ý với các mục đồng ý liên quan đến liên kết ID và tiến hành bước tiếp theo.',
        'registration_email'    => 'Đăng ký bằng email',
        'dottree'               => "Dottree's",
    ],
    'register_method' => [
        'or'                    => 'Bạn đã có tài khoản? ,',
        'title'                 => 'Đăng ký',
        'for_users'             => 'Dành cho người dùng',
        'login_here'            => 'Đăng nhập tại đây',
        'brief_greeting'        => 'Lời chào ngắn gọn hoặc mô tả về yêu cầu đăng ký mới',
        'registration_email'    => 'Đăng ký bằng email',
        'registration_google'   => 'Đăng ký bằng tài khoản google',
    ],
    'login_method' => [
        'here'              => 'ở đây',
        'login'             => 'Đăng nhập',
        'for_user'          => 'Dành cho người dùng',
        'brief_greeting'    => 'Lời chào ngắn gọn hoặc mô tả về yêu cầu đăng ký mới',
        'login_with_email'  => 'Đăng nhập bằng email của bạn',
        'login_with_google' => 'Đăng nhập bằng tài khoản google',
        'forgot_password'   => 'Quên mật khẩu?',
        'dont_have_account' => "Nếu bạn chưa có tài khoản,",
        'new_registration'  => 'dễ dàng để đăng ký!'
    ],
    'house' => [
        'field' => [
            'name'          => 'Tên nhà',
            'description'   => 'Mô tả',
            'province_code' => 'Tỉnh',
            'district_code' => 'Quân',
            'ward_code'     => 'Phường',
            'address'       => 'Địa chỉ',
            'thumbnail'     => 'Ảnh đại diện',
            'category_id'   => 'Danh mục',
        ]
    ],

    'side_menu'   => [
        'log_in_email'            => 'Đăng nhập bằng địa chỉ email của bạn',
        'log_in_google'           => 'Đăng nhập từ Google',
        'forgot_password'         => 'Quên mật khẩu của bạn?',
        'here'                    => 'ở đây',
        'new_registration'        => 'Dễ dàng! Nhấn vào đây để đăng ký mới',
        'apply_lessor'            => 'Nhấn vào đây để đăng ký làm chủ nhà!',
        'button_become_fun'       => 'Trở thành chủ nhà của Rentalhouse và có những giây phút vui vẻ!',
        'button_become'           => 'Trở thành chủ nhà của Rentalhouse!',
        'profile_setting'         => 'Thiết lập hồ sơ',
        'management'              => 'Quản lý',
        'request'                 => 'Yêu cầu',
        'notification'            => 'Thông báo',
        'language_select'         => 'Chọn ngôn ngữ',
        'contact'                 => 'Liên hệ',
        'logout'                  => 'Đăng xuất',
        'company'                 => 'Công ty',
        'term_service'            => 'Điều khoản dịch vụ',
        'privacy'                 => 'Chính sách bảo mật',
        'description_base'        => 'Mô tả dựa trên SCTL',
        'select_your_language'    => 'Chọn ngôn ngữ của bạn',
    ],

    'top'   => [
        'capacity'              => 'Số người',
    ],

    'search'        => [
        'search'                => 'Tìm kiếm',
        'keyword'               => 'Từ khóa',
        'placeholder_keyword'   => 'Tìm kiếm theo từ khóa',
        'address'               => 'Địa chỉ',
        'district'              => 'Quận',
        'ward'                  => 'Phường',
        'province'              => 'Tỉnh thành',
        'min_price'             => 'Giá tối thiểu',
        'max_price'             => 'Giá tối đa',
        'to'                    => 'đến',
        'placeholder_min_price' => 'Nhập giá tối thiểu',
        'placeholder_max_price' => 'Nhập giá tối đa',
        'category'              => 'Danh mục',
        'placeholder_category'  => 'Chọn danh mục',
        'clear_form'            => 'Xóa',
        'search'                => 'Tìm kiếm',

    ],

    'search_result'     => [
        'title'         => 'Tiêu đề',
        'houses'        => 'căn hộ',
        'house'         => 'căn hộ',
        'found'         => 'đã tìm thấy',
        'price'         => 'Giá',
        'capacity'      => 'Sức chứa',
        'type'          => 'Loại',
        'no_result'     => 'Không có kết quả nào được tìm thấy',
        'related_house' => 'Căn hộ liên quan',
        'person'        => 'người',

    ],

    'header'        => [
        'search_here' => 'Tìm kiếm ở đây...',
        'sign_in'     => 'Đăng nhập',
        'join'        => 'Tham gia',
        'logout'      => 'Đăng xuất',

    ]
];
