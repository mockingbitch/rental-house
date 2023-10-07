<?php

return [
    'user' => [
        'field'   => [
            'email'                 => 'Email',
            'adult_email'           => 'Adult Email',
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password',
            'firstName'             => '性',
            'lastName'              => '名',
            'birthday'              => 'Birthday',
            'country'               => 'Country',
            'city'                  => 'City',
            'nick_name'             => 'Nick Name',
            'child_name'            => 'Kid Name',
            'adult_nick_name'       => 'Adult Nickname',
            'first_name_kana'       => '性（フリガナ）',
            'last_name_kana'        => '名（フリガナ）',
        ],
		'reserved' => [
            'reserved'    => '予約一覧',
            'no_reserved'    => '申込みが完了している、レッスンがありません。',
			'message_no_reserved'    => 'レッスンに申込みをすると、申込んだレッスンを一覧で確認することができます。',
			'label_time'    => '分',
			'label_age'    => '年齢',
			'button_time'    => '解約する',
			'button_skip'    => 'スキップする',
			'button_cancel_skip'    => '解約する',
			'lesson_status_public'    => '公開',
			'popup_select_schedule_label'    => 'レッスンを選択',
			'popup_select_schedule_button_cancel'    => 'キャンセル',
			'popup_select_schedule_button_skip'    => 'スキップする',
			'popup_select_reason_label'    => 'レッスンを解約しますが、よろしいですか？',
			'popup_select_reason_reason'    => '理由',
			'popup_select_reason_reason_placeholder'    => '(仮)解除理由を選んだください',
			'popup_select_reason_reason_option1'    => 'レッスン料金が高い',
			'popup_select_reason_reason_option2'    => '教え方やスタイルが合わない',
			'popup_select_reason_reason_option3'    => '他の習い事をはじめた',
			'popup_select_reason_reason_option4'    => '興味がなくなった',
			'popup_select_reason_reason_option5'    => 'その他',
			'popup_select_reason_button_cancle'    => 'キャンセル',
			'popup_select_reason_button_confirm'    => '解除する',

        ],
		'history' => [
            'history'              => '履歴',
            'no_history'    => '申込みが完了している、レッスンがありません。',
			'message_no_reserved'    => 'レッスンに申込みをすると、申込んだレッスンを一覧で確認することができます。',
			'label_time'    => '分',
			'label_age'    => '年齢',
			'button_input_review'    => 'レビューを回答する',
			'button_show_review'    => '回答したレビューを見る',
        ],
    ],
    'kid' => [
        'field' => [
            'name'              => 'Kid name',
            'learning_style'    => 'Learning style',
        ],
    ],
    'lesson' => [
        'field' => [
            'title'             => 'Title',
            'price'             => 'Price',
            'description'       => 'Description',
            'target_age_from'   => 'Age From',
            'target_age_to'     => 'Age To',
            'min_learner'       => 'Min learner',
            'max_learner'       => 'Max learner',
            'number_of_meets'   => 'Number Of Meets',
            'lesson_hour'       => 'Hour',
            'lesson_minute'     => 'Minute',
            'total_of_meets'    => 'Total Of Meets',
            'language'          => 'Language',
            'style'             => 'Style',
            'currency'          => 'Currency',
            'cover_image'       => 'Cover Image',
            'short_video_for_parent' => 'Short video for parent',
            'short_video_for_learner' => 'Short video for learner',
            'template'          => 'Template',
            'lesson_content'    => 'Content',
            'teacher_experience' => 'Teacher Experience',
            'start_date'        => 'Start Date',
            'end_date'          => 'End Date',
            'note'              => 'Note',
            'status'            => 'Status',
        ]
    ],
    'lesson_schedule' => [
        'field' => [
            'weekday'     => 'Weekday',
            'start_time'  => 'Start time',
            'end_time'    => 'End time',
        ],
    ],
    'login' => [
        'title'     => 'ログイン',
        'hint'      => 'ヒントヒントヒントヒントヒント',
        'note'      => '注意事項注意事項注意事項注意事項',
        'button'    => 'ログイン',
    ],
    'register' => [
        'title'                 => '新規登録',
        'note_email'            => '仮）アカウント作成を完了した後は、メールアドレス変更が可能です。',
        'note_password'         => '注意事項注意事項注意事項注意事項',
        'hint_password'         => 'ヒントヒントヒントヒントヒント',
        'term_of_service'       => '利用規約',
        'privacy_policy'        => 'プライバシーポリシー',
        'external_service'      => '外部サービス',
        'term'                  => 'とのID連携に関する同意項目に同意いただいた上で、次にお進みください。',
        'registration_email'    => 'メールアドレスで新規登録',
        'RentalHouse'               => 'RentalHouseの',
    ],
    'register_method' => [
        'or'                    => 'もしくは、',
        'title'                 => '新規登録',
        'for_users'             => 'ユーザーに向けて、',
        'login_here'            => 'ログインはこちら',
        'brief_greeting'        => '簡単な挨拶、もしくは新規登録のお願いの説明文',
        'registration_email'    => 'メールアドレスで新規登録',
        'registration_google'   => 'Googleから新規登録',
    ],
    'login_method' => [
        'here'              => 'こちら',
        'login'             => 'ログイン',
        'for_user'          => 'ユーザーに向けて、',
        'brief_greeting'    => '簡単な挨拶、もしくは新規登録のお願いの説明文',
        'login_with_email'  => 'メールアドレスからログイン',
        'login_with_google' => 'Google からログイン',
        'forgot_password'   => 'パスワードをお忘れの方は',
        'dont_have_account' => "アカウントをお持ちではない方は、",
        'new_registration'  => 'かんたんに新規登録 !'
    ],
    'register_success' => [
        'here'                      => 'こちら',
        'contact_us'                => 'お問い合わせは',
        'copy_right'                => 'Copyright © RentalHouse, Inc. All Rights Reserved',
        'expires_in'                => '認証URLの有効期限は24時間です。',
        'verify_email'              => 'メール認証をお願いします！',
        'click_the_url'             => 'メールに送信されたURLをクリックして',
        'please_authenticate'       => '認証を行なってください。',
        'registration_not_complete' => 'まだ登録は完了していません。',
    ],
    'forgot_password' => [
        'button'                => 'パスワード再設定',
        'reset_password'        => 'パスワード再設定',
        'we_will_send_url'      => 'パスワード再設定用のURLをお送りします。',
        'please_enter_email'    => '登録しているメールアドレスを入力してください。',
        'field' => [
            'email' => 'Email'
        ],
    ],
    'forgot_password_pending' => [
        'here'                  => 'こちら',
        'copy_right'            => 'Copyright © RentalHouse, Inc. All Rights Reserved',
        'expires_in'            => '認証URLの有効期限は5分です。',
        'contact_us'            => 'お問い合わせは',
        'please_reset'          => '再設定を行なってください。',
        'reset_password'        => 'パスワード再設定',
        'click_the_url'         => 'メールアドレスに送信されたURLをクリックして',
        'reset_not_complete'    => 'まだパスワードの再設定は完了していません。',
    ],
    'reset_password' => [
        'hint'                  => 'ヒントヒントヒントヒントヒント',
        'note'                  => '注意事項注意事項注意事項注意事項',
        'reset_password'        => 'パスワード再設定',
        'enter_new_password'    => '新しいパスワードを入力してください。',
        'setting_completed'     => '設定完了',
        'field' => [
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password',
        ],
    ],
    'reset_password_success' => [
        'here'                      => 'こちら',
        'we_hope'                   => '引き続きRentalHouseをお楽しみください。',
        'contact_us'                => 'お問い合わせは',
        'return_top'                => 'TOPページに戻る',
        'copy_right'                => 'Copyright © RentalHouse, Inc. All Rights Reserved',
        'return_login'              => 'ログインページに戻る',
        'reset_password'            => 'パスワード再設定',
        'password_has_been_reset'   => 'パスワード再設定が完了しました。',
    ],
    "create_lesson_success" => [
        'notification'                  => 'レッスン登録 申請完了',
        'thank_to'                      => '申請ありがとうございます。事務局で内容を審査の上、登録させていただきます。 審査には3日~5日営業日頂戴しております。',
        'go_back'                       => '戻ってLesson内容を再度修正する',
        'to_dashboard'                  => 'ダッシュボードに戻る',
        'contact_us'                    => 'お問い合わせはこ',
        'here'                          => 'ちら',
        'copy_right'                    => 'Copyright © RentalHouse, Inc. All Rights Reserved',
    ],
    "create_lesson_failed" => [
        'notification'                  => 'lessonの登録が失敗しました。',
        'sorry'                         => "仮すみません。",
        'reason'                        => '何かの理由であいうえおの問題により、',
        'create_fail'                   => '授業登録が失敗しました。',
        'try_again'                     => 'もう一度お試しお願いします。',
        'go_back'                       => '戻ってLesson内容を再度修正する',
        'to_dashboard'                  => 'Dashboardに戻る（下書き保存）',
        'contact_us'                    => 'お問い合わせは',
        'here'                          => 'こちら',
        'copy_right'                    => 'Copyright © RentalHouse, Inc. All Rights Reserved',
    ],
    'information' => [
        'index' => [
            'title' => '新規登録',
            'verification' => 'Verification',
            'account_info' => 'Account Info',
            'learner_info' => 'Learner Info',
        ],
        'account_info' => [
            'adult_first_name'  => '性',
            'adult_last_name'   => '名',
            'adult_first_name_kana'  => '性（フリガナ)',
            'adult_last_name_kana'   => '名（フリガナ)',
            'adult_nick_name'   => 'Adult Nickname',
            'birthday'          => 'Birthday',
            'country'           => 'Residential Area',
            'city'              => 'City',
            'next'              => '次へ',
            'city_tooltip'      => "あなたが住んでいる都市を選択してください。",
            'country_tooltip'   => "あなたが住んでいる国を選択してください。",
            'note_nick_name'    => '仮)アカウント作成を完了した後は、メールアドレス変更が可能です。'
        ],
        'learner_info' => [
            'skip'              => 'スキップ（あとで登録）',
            'nickname'          => 'Kid Nick name',
            'placeholder_nickname' => 'nick name',
            'kid_first_name'    => 'Kid First name',
            'kid_last_name'     => 'Kid Last name',
            'name'              => '別',
            'birthday'          => 'Birthday',
            'age'               => 'Age',
            'interest_category' => 'Interest Category',
            'another_kids'      => 'Another Kids',
            'next'              => '次へ',
            'learning_style'    => 'Learning Style',
            'complete_register' => '登録完了'
        ],
        'completed' => [
            'title'             => '会員登録が完了しました。',
            'thank_you'         => '"ご登録ありがとうございます。"',
            'guide_to_teacher'  => 'サービスを利用される方は、トップページへアクセスしてください。',
            'alternatively'     => '先生アカウント作成をする方は「先生になる」ボタンから登録してください。',
            'register_teacher'  => '先生として登録する',
            'go_to_dashboard'   => 'ダッシュボードに移動',
            'go_to_top_page'    => 'トップページ',
            'contact_us'        => 'お問い合わせはこちら',
        ],
    ],
    'search' => [
        'title'         => 'レッスンを検索する',
        'button'        => '検索',
        'age'           => 'Age',
        'price_range'   => 'Price range',
		'field'   => [
            'lesson_title'              => 'キーワードから探す',
            'lesson_title_placeholder'  => 'キーワードを入力',
			'min_age_title'             => '対象年齢下限',
            'min_age_placeholder'       => '年齢',
			'max_age_title'             => '対象年齢上限',
            'max_age_placeholder'       => '年齢',
			'min_price_title'           => '料金下限',
            'min_price_placeholder'     => '料金',
			'max_price_title'           => '料金上限',
            'max_price_placeholder'     => '料金',
			'select_date_title'         => '日付',
            'select_date_placeholder'   => '日付',
			'select_date_default'       => '日程を設定',
			'week_day_title'            => '曜日',
			'start_date_title'          => '開始日',
			'end_date_title'            => '終了日',
			'select_date_clear'         => 'リセット',
			'select_date_confirm'       => '決定',
			'button_clear_form'         => '条件をクリア',
			'button_submit_form'        => '検索する',

        ],
    ],
	'searchResult' => [
        'title'                => '検索結果',
        'keyword_default'      => 'キーワードなし',
        'age_default'          => '年齢を設定',
        'price_default'        => '費用を設定',
		'date_default'         => '費用を設定',
		'week_day_default'     => '日程を設定',
		'similar_content'      => 'あなたへのおすすめレッスン',
		'review'               => 'レビュー',
		'price'                => '料金',
		'ages'                 => '対象年齢',
		'date'                 => '日程',
		'time'                 => 'レッスン時間',

    ],
    'humbeger' => [
        'become_teacher'    => '先生になる',
        'switch_to_teacher' => '先生に切替え',
        'switch_to_user'    => 'ユーザーに切り替え',
    ],
    'schedule_application' => [
        'field' => [
            'kid' => 'kid name'
        ]
    ],
    'request' => [
        'field' => [
            'summary'       => 'Summary',
            'category_id'   => 'Category',
            'detail'        => 'detail',
            'min_price'     => 'Min Price',
            'max_price'     => 'Max Price',
            'about_teacher' => 'About Teacher',
            'language'      => 'Language',
            'min_time'      => 'Min Time',
            'max_time'      => 'Max Time',
            'start_time'    => 'Start Time',
            'end_time'      => 'End Time',
            'min_age'       => 'Min Age',
            'max_age'       => 'Max Age',
            'weekdays'      => 'Weekdays',
            'status'        => 'Status',
        ],
		'requested' => [
			'requested'       => '依頼',
			'list_of_request'       => '一覧',
			'note'       => 'お子さんが興味、関心のある分野のレッスンをリクエストすることができます。リクエストを受け付けたら、レッスンの実現に向けてサポートをします。',
			'request_lesson'       => 'リクエストする',
			'no_request1'       => 'レッスンが登録がされていません。',
			'no_request2'       => 'リクエストタブより希望のレッスンを登録してください。',
		],
		'card_lesson_request' => [
			'label_time'       => 'yyyy/mm/dd',
			'flag_new'       => 'NEW',
			'label_about_job'       => 'About Data Scientist Job Introduction',
			'label_price'       => '料金',
			'label_class_time'       => 'レッスン時間',
			'label_language'       => '言語',
			'label_time_zone'       => '18:00 ~ 20:00',
			'label_spec'       => '先生に求める経験',
			'label'       => 'レッスン詳細',
			'show_more'       => 'もっと見る',
			'show_less'       => '閉じる',
			'delete'       => '削除する',
			'edit'       => '編集する',
		],
		'popup_confirm_delete' => [
			'delete'       => '削除する',
			'cancle'       => 'キャンセル',
			'label_one'       => 'リクエストを削除しますが、よろしいですか？',
			'label_two'       => '削除すると復元ができますせん。 レッスンが登録されている場合は、対象レッスンを検索をしてください。',
			'no_login_delete'       => '削除する',
			'no_login_cancle'       => 'キャンセル',
			'no_login_label_one'       => '興味のあるレッスンをリクエスト',
			'no_login_label_two'       => 'リクエストとは',
			'no_login_label_note1'       => '1. 子供の興味・関心のあるレッスンをリクエストすることができます。',
			'no_login_label_note2'       => '2, リクエストに対する提案内容を事前に確認して、好みの先生を選ぶことができます。',
			'no_login_label_note3'       => '3. 他のユーザーのリクエストに対して提案されているレッスンに参加することができます。',
			'no_login_login'       => 'ログイン',
			'no_login_register'       => '簡単新規登録',
		],

    ],
    'request_form' => [
        'field' => [
            'request_summary'    => '概要',
            'lesson_category'    => 'カテゴリ',
            'age'                => '対象年齢',
            'price_range'        => '料金',
            'lesson_time'        => 'レッスン時間',
            'timezone'           => '希望の時間帯',
            'language'           => '言語',
            'about_teacher'      => '先生の経験・条件',
            'request_detail'     => '詳細',
            'clear'              => '条件をクリア',
            'submit_request'     => 'リクエストする',
            'cancel'             => 'キャンセル',
            'submit'             => '登録する',
        ],
        'modal_title'     => 'リクエストを登録します。',
        'modal_note_1'    => 'よろしいですか？',
        'modal_note_2'    => '説明',
        'modal_content_1' => '"①リクエスト内容は、リクエストタブからいつでも確認ができます。"',
        'modal_content_2' => '        ②レッスンが登録されるまでリクエスト内容の変更ができます。',
        'modal_content_3' => '③リクエストに先生がレッスンを登録したら通知が届きます。',
    ],
    'lesson_detail' => [
        'field' => [
            'price' => '料金',
            'ages' => '対象年齢',
            'learners' => '対象人数',
            'week' => 'レッスン頻度',
            'time' => 'レッスン時間',
            'language' => '言語',
        ],
        'show_more' => 'もっと見る',
        'for_parent' => '大人向け動画',
        'for_kid' => '子供向け動画',
        'schedule' => 'レッスン予定',
        'apply' => 'Apply',
        'available_seats' => 'Available seats',
        'full' => 'Full',
        'full_seats' => 'Full seats',
        'lesson_outline' => 'レッスン概要',
        'teacher_expertise' => '先生の経験',
        'additional_note' => 'その他・補足 (宿題についてなど)',
        'reviews' => 'レビュー',
        'show_more' => 'もっと見る',
        'show_less' => '閉じる',
    ],
	'week_day' => [
		'Mon'       => '月',
		'Tue'       => '火',
		'Wed'       => '水',
		'Thu'       => '木',
		'Fri'       => '金',
		'Sat'       => '土',
		'Sun'       => '日',
	],
	'notification' => [
		'no_result'       => '通知がありません。',
		'flag_new'        => 'NEW',
		'notification_title'        => '通知一覧',
		'notification_detail'        => 'もっとみる',
	],
    'teacher_dashboard' => [
        'achievement' => '実績',
        'more_button' => 'もっと見る',
        'total_revenue' => '売上',
        'total_lessons' => 'レッスン開催数',
        'total_learner' => '教えた人数',
        'average_per_lesson' => 'レッスン単価',
        'lesson_feedbacks' => 'レッスンFB',
        'publish_lesson' => '公開',
        'public' => '公開',
        'price' => '料金',
        'price_unit' => '円',
        'min' => '分',
        'age' => '年齢',
        'draft_lesson' => '下書き',
        'new_lesson' => 'レッスン登録',
    ],
    'create_lesson' => [
        'field' => [
            'lesson_title' => 'レッスンタイトル',
            'lesson_category' => 'カテゴリ',
            'short_description' => '大人向け簡単な説明',
            'target_age' => '対象年齢',
            'learners' => '生徒数',
            'language' => '言語',
            'lessons_style' => 'レッスンスタイル',
            'schedule' => 'スケジュール',
            'price' => '料金',
            'price_unit' => '円',
            'cover_image' => 'カバー画像',
            'video_for_kid' => '子供向け レッスン説明動画',
            'video_for_parent' => '大人向け レッスン説明動画',
            'choose_template' => 'テンプレート選択',
            'lesson_content' => 'レッスン内容',
            'teacher_experience' => '先生の経験',
            'lesson' => '教材',
            'more_lesson' => '追加する'
        ],
        'save_to_draft' => '下書き保存',
        'cancel' => 'キャンセル',
        'next' => '次へ',
        'schedule_note_1' => 'このレッスンは週に',
        'schedule_note_2' => '回開催します。',
        'schedule_note_3' => 'レッスン時間は',
        'schedule_note_4' => '時間',
        'schedule_note_5' => '分 です。',
        'schedule_note_6' => 'このレッスンは合計',
        'schedule_note_7' => '回開催します。',
    ],
    'multi_step' => [
        'step_1' => 'レッスン情報',
        'step_2' => '詳細',
        'step_3' => '教材登録',
    ],
    'course_header' => [
        'lesson_course' => 'コース管理',
        'schedule' => 'スケジュール管理',
        'lesson_record' => 'レッスン実績',
    ],
    'lesson_course' => [
        'all' => '全て',
        'public' => '公開中',
        'private' => 'Private',
        'draft' => '下書き',
        'suspend' => '公開停止中',
        'pending' => '審査中',
        'lessons' => 'レッスン',
        'create_lesson' => 'レッスン作成',
        'price' => '料金',
        'price_unit' => '円',
        'edit' => '編集',
        'course' => 'コース',
        'show_more' => 'もっと見る',
        'date' => '日付',
        'age' => '年齢',
        'add_course' => '追加する',
        'meeting' => 'スケジュール',
        'add_meeting_slot' => 'スケジュール追加',
        'students_members' => '生徒一覧',
        'empty_state' => '登録している学生がまだいません。',
        'application_deadline' => '申込み期限設定',
        'course_note_1' => '申込み期限はレッスンの',
        'course_note_2' => '日前までです。',
        'course_note_3' => '予約締切は5日から14日まで設定が可能です。',
        'course_note_4' => '初期設定は5日前です。',
        'course_note_5' => '予約締切後のユーザーキャンセルは不可となります。',
        'course_note_6' => 'ただし、先生の都合でレッスンをキャンセルする場合は全額返金対応となります。',
        'cancel' => 'キャンセル',
        'publish_schedule' => '公開',
        'update' => 'Update',
        'delete_course' => 'コース削除',
        'course_title' => 'タイトル',
    ],
    'schedule' => [
        'schedule_management' => 'スケジュール管理',
        'status' => '申込状況',
        'attend' => '開催',
    ],
    'record' => [
        'lesson_record' => 'レッスン実績',
        'total' => '合計',
        'lessons' => '教えた数',
        'applicant' => '教えた人数',
        'review' => 'レビュー',
        'price' => '売上',
    ],
];
