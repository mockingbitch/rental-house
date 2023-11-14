<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attributeが正しくありません。:attributeを正しく入力してください',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => '有効なメールアドレスを入力してください',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'halfwidth' => 'test test',
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => ':attributeは:max文字以内に入力してください',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => ':attributeは:max文字以内に入力してください',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attributeは:min文字以上に入力してください',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attributeは:min文字以上に入力してください',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'password_confirmation' => ':attribute1と:attribute2が異なっています',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => '必須項目です',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => ':otherと:attributeが異なっています',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],

        'email' => [
            'unique' => 'このメールアドレスは既に使われています。再度ご確認ください',
            'max' => ':max文字以内に入力してください',
            'halfwidth' => '有効なメールアドレスを入力してください',
            'required' => '有効なメールアドレスを入力してください',
            'email'     => '有効なメールアドレスを入力してください',
        ],

        'password' => [
            'max' => ':max文字以内に入力してください',
            'min' => ':min文字以上に入力してください',
            'halfwidth' => '半角英数字、記号を組み合わせた8文字以上で入力してください',
            'required' => '半角英数字、記号を組み合わせた8文字以上で入力してください',
        ],

        'password_confirmation' => [
            'halfwidth' => '半角英数字、記号を組み合わせた8文字以上で入力してください',
            'required' => '半角英数字、記号を組み合わせた8文字以上で入力してください',
        ],
        'title' => [
            'required' => '100文字以内で入力ください',
            'max' => '100文字以内で入力ください',
        ],
        'category_id' => [
            'required' => '選択してください',
        ],
        'short_description_for_parent' => [
            'required' => '100文字以内で入力ください',
            'max' => '100文字以内で入力ください',
        ],
        'class_capacity' => [
            'required' => '必須項目です'
        ],
        'target_age_from' => [
            'required' => '必須項目です'
        ],
        'target_age_to' => [
            'required' => '必須項目です'
        ],
        'class_detail' => [
            'required' => '選択してください'
        ],
        'number_of_meets' => [
            'required' => '必須項目です'
        ],
        'lesson_hour' => [
            'required' => '必須項目です'
        ],
        'lesson_minute' => [
            'required' => '必須項目です',
            'gt' => 'hourまたはminutesが正しくありません。再度ご確認ください',
        ],
        'price' => [
            'required' => '料金は半角数字で入力ください',
            'numeric' => '料金は半角数字で入力ください',
            'not_in' => '料金は０よりに入力してください',
            'min' => '料金は０よりに入力してください',
        ],
        'cover_image' => [
            'required' => '必須項目です',
            'mimes' => 'ファイル形式が正しくありません。JPEG、JPG、PNG、GIF、BMP形式の画像をアップロードしてください',
        ],
        'short_video_for_learner' => [
            'mimetypes' => 'ファイル形式が正しくありません。MP4、AVI、MOV、WEBM、FLV形式の画像をアップロードしてください',
            'max' => '100MB以下のファイルをアップロードしてください',
        ],
        'class_description' => [
            'required' => '最低500文字以上で入力ください',
            'min' => '最低500文字以上で入力ください',
        ],
        'teacher_experience' => [
            'required' => '最低200文字以上で入力ください',
            'min' => '最低200文字以上で入力ください ',
        ],
        'file_upload.*' => [
            'mimes' => 'ファイル形式が正しくありません。PDF形式のファイルをアップロードしてください',
        ],
        'language' => [
            'required' => '選択してください',
        ],

        // fields for register step 2 - input parent information
        'country' => [
            'required' => '必須項目です',
        ],
        'city' => [
            'required' => '必須項目です',
        ],
        'nickName' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
        ],
        'firstName' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
        ],
        'lastName' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
        ],
        'firstNameKana' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
            'kana'     => ':attributeは全角カタカナで入力してください',
        ],
        'lastNameKana' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
            'kana'     => ':attributeは全角カタカナで入力してください',
        ],
        'year' => [
            'required' => '必須項目です',
        ],
        'month' => [
            'required' => '必須項目です',
        ],
        'day' => [
            'required' => '必須項目です',
        ],
        'birthday' => [
            'before' => 'Birthdayは当日より過去日付に入力してください',
        ],

        // fields for register step 3 - input learner information
        'kids.*.nickName' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
            'distinct' => '別のニックネームで登録してください',
        ],
        'kids.*.firstName' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
        ],
        'kids.*.lastName' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
        ],
        'kids.*.name' => [
            'distinct' => '別の名前で登録してください',
        ],
        'kids.*.year' => [
            'required' => '必須項目です',
        ],
        'kids.*.month' => [
            'required' => '必須項目です',
        ],
        'kids.*.day' => [
            'required' => '必須項目です',
        ],
        'kids.*.birthday' => [
            'before' => 'Birthdayは当日より過去日付に入力してください',
        ],
        'kids.*.categories' => [
            'min' => '必須項目です',
        ],

        // fields for onboarding teacher step 1
        'first_name_kana' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
            'kana'     => ':attributeは全角カタカナで入力してください',
        ],
        'last_name_kana' => [
            'required' => '必須項目です',
            'max'      => ':attributeは:max文字以内に入力してください',
            'kana'     => ':attributeは全角カタカナで入力してください',
        ],
        'profile_image'         => [
            'required'  => '必須項目です',
            'mimes'     => 'ファイル形式 jpeg, jpg, png, gif, bmp をサポートしています',
            'max'  => 'サイズは最大20MBまでアップロードが可能です',
        ],
        'first_name'            => [
            'required'  => '必須項目です',
            'max'       => '100文字以内に入力してください',
        ],
        'last_name'             => [
            'required'  => '必須項目です',
            'max'       => '100文字以内に入力してください',
        ],
        'city_id.required'      => '必須項目です',
        'country_code.required' => '必須項目です',
        'phone'                 => [
            'required'  => '必須項目です',
            'min'       => '9数字以上に入力してください',
            'max'       => '11数字以内に入力してください',
        ],
        'job.required'          => '選択してください',
        'salary.required'       => '選択してください',
        'headline'              => [
            'required'  => '必須項目です',
            'max'       => '80文字以内に入力してください',
        ],
        'about'                 => [
            'required'  => '必須項目です',
            'max'       => '200文字以内に入力してください',
        ],
        'short_video_for_learner' => [
            'mimetypes' => 'ファイル形式 mp4, avi, mov, webm, flv をサポートしています',
            'max'       => ' サイズは最大 20MBまでアップロードが可能です ( 推奨 30~90秒程度)',
            'required'  => '必須項目です',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
    'learner' => [
        'required'  => "子供の名前を入力くださいい",
        'max'       => '100文字以内に入力してください',
    ],
        // user info validation
    'parent_information' => [
        'nickname' => [
            'max' => '100文字以内に入力してください',
        ],
        'first_name' => [
            'max' => '100文字以内に入力してください',
        ],
        'last_name' => [
            'max' => '100文字以内に入力してください',
        ],
        'first_name_kana' => [
            'max' => '100文字以内に入力してください',
            'not_kana' => '全角カタカナで入力してください',
        ],
        'last_name_kana' => [
            'max' => '100文字以内に入力してください',
            'not_kana' => '全角カタカナで入力してください',
        ],
    ]
];
