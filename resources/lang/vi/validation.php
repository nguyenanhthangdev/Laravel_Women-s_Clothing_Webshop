<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau đây chứa các thông báo lỗi mặc định được sử dụng bởi
    | lớp validator. Một số quy tắc có nhiều phiên bản như các quy tắc kích thước.
    | Bạn có thể tùy chỉnh mỗi thông báo này ở đây.
    |
    */

    'accepted'             => ':attribute phải được chấp nhận.',
    'active_url'           => ':attribute không phải là một URL hợp lệ.',
    'after'                => ':attribute phải là một ngày sau :date.',
    'after_or_equal'       => ':attribute phải là một ngày sau hoặc bằng :date.',
    'alpha'                => ':attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash'           => ':attribute chỉ có thể chứa các chữ cái, số và dấu gạch ngang.',
    'alpha_num'            => ':attribute chỉ có thể chứa các chữ cái và số.',
    'array'                => ':attribute phải là một mảng.',
    'before'               => ':attribute phải là một ngày trước :date.',
    'before_or_equal'      => ':attribute phải là một ngày trước hoặc bằng :date.',
    'between'              => [
        'numeric' => ':attribute phải ở giữa :min và :max.',
        'file'    => ':attribute phải ở giữa :min và :max kilobytes.',
        'string'  => ':attribute phải ở giữa :min và :max ký tự.',
        'array'   => ':attribute phải có giữa :min và :max mục.',
    ],
    'boolean'              => ':attribute trường phải là đúng hoặc sai.',
    'confirmed'            => ':attribute xác nhận không khớp.',
    'date'                 => ':attribute không phải là một ngày hợp lệ.',
    'date_format'          => ':attribute không khớp với định dạng :format.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải là :digits chữ số.',
    'digits_between'       => ':attribute phải ở giữa :min và :max chữ số.',
    'dimensions'           => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct'             => ':attribute trường có giá trị trùng lặp.',
    'email'                => ':attribute phải là một địa chỉ email hợp lệ.',
    'exists'               => ':attribute được chọn không hợp lệ.',
    'file'                 => ':attribute phải là một tệp.',
    'filled'               => ':attribute trường phải có giá trị.',
    'image'                => ':attribute phải là một hình ảnh.',
    'in'                   => ':attribute được chọn không hợp lệ.',
    'in_array'             => ':attribute trường không tồn tại trong :other.',
    'integer'              => ':attribute phải là một số nguyên.',
    'ip'                   => ':attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4'                 => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6'                 => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json'                 => ':attribute phải là một chuỗi JSON hợp lệ.',
    'max'                  => [
        'numeric' => ':attribute không thể lớn hơn :max.',
        'file'    => ':attribute không thể lớn hơn :max kilobytes.',
        'string'  => ':attribute không thể lớn hơn :max ký tự.',
        'array'   => ':attribute không thể có nhiều hơn :max mục.',
    ],
    'mimes'                => ':attribute phải là một tệp loại: :values.',
    'mimetypes'            => ':attribute phải là một tệp loại: :values.',
    'min'                  => [
        'numeric' => ':attribute phải ít nhất là :min.',
        'file'    => ':attribute phải ít nhất là :min kilobytes.',
        'string'  => ':attribute phải ít nhất là :min ký tự.',
        'array'   => ':attribute phải có ít nhất :min mục.',
    ],
    'not_in'               => ':attribute được chọn không hợp lệ.',
    'numeric'              => ':attribute phải là một số.',
    'present'              => ':attribute trường phải có mặt.',
    'regex'                => ':attribute định dạng không hợp lệ.',
    'required'             => ':attribute trường là bắt buộc.',
    'required_if'          => ':attribute trường là bắt buộc khi :other là :value.',
    'required_unless'      => ':attribute trường là bắt buộc trừ khi :other trong :values.',
    'required_with'        => ':attribute trường là bắt buộc khi :values có mặt.',
    'required_with_all'    => ':attribute trường là bắt buộc khi :values có mặt.',
    'required_without'     => ':attribute trường là bắt buộc khi :values không có mặt.',
    'required_without_all' => ':attribute trường là bắt buộc khi không có :values có mặt.',
    'same'                 => ':attribute và :other phải khớp.',
    'size'                 => [
        'numeric' => ':attribute phải là :size.',
        'file'    => ':attribute phải là :size kilobytes.',
        'string'  => ':attribute phải là :size ký tự.',
        'array'   => ':attribute phải chứa :size mục.',
    ],
    'string'               => ':attribute phải là một chuỗi.',
    'timezone'             => ':attribute phải là một vùng hợp lệ.',
    'unique'               => ':attribute đã được lấy.',
    'uploaded'             => ':attribute tải lên thất bại.',
    'url'                  => ':attribute định dạng không hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Ở đây bạn có thể chỉ định các thông báo xác thực tùy chỉnh cho các thuộc tính
    | sử dụng quy ước "attribute.rule" để đặt tên cho các dòng. Điều này giúp nhanh
    | chóng chỉ định một dòng ngôn ngữ cụ thể tùy chỉnh cho một quy tắc thuộc tính nhất định.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau đây được sử dụng để thay thế các thuộc tính vị trí
    | với cái gì đó thân thiện hơn với người đọc như "E-Mail Address" thay vì
    | "email". Điều này giúp chúng ta làm cho thông báo của mình biểu cảm hơn.
    |
    */

    'attributes' => [
        'fullname' => 'họ và tên',
        'email' => 'email',
        'phone' => 'số điện thoại',
        'username' => 'tên đăng nhập',
        'password' => 'mật khẩu',
        'status' => 'trạng thái',
        'image' => 'ảnh đại diện',
    ],

];
