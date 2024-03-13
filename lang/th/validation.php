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

    'accepted' => 'ต้องยอมรับ :attribute',
    'accepted_if' => 'ต้องยอมรับ :attribute เมื่อ :other เป็น :value',
    'active_url' => ':attribute ต้องเป็น URL ที่ถูกต้อง',
    'after' => ':attribute ต้องเป็นวันที่หลังจาก :date',
    'after_or_equal' => ':attribute ต้องเป็นวันที่หลังหรือเท่ากับ :date',
    'alpha' => ':attribute ต้องประกอบด้วยตัวอักษรเท่านั้น',
    'alpha_dash' => ':attribute ต้องประกอบด้วยตัวอักษร, ตัวเลข, เครื่องหมายขีดกลาง และขีดล่างเท่านั้น',
    'alpha_num' => ':attribute ต้องประกอบด้วยตัวอักษรและตัวเลขเท่านั้น',
    'array' => ':attribute ต้องเป็นอาร์เรย์',
    'ascii' => ':attribute ต้องประกอบด้วยอักขระตัวเล็ก, อักขระตัวใหญ่ และสัญลักษณ์ที่มีขนาดเท่ากับหนึ่งไบต์เท่านั้น',
    'before' => ':attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal' => ':attribute ต้องเป็นวันที่ก่อนหรือเท่ากับ :date',
    'between' => [
        'array' => ':attribute ต้องมีระหว่าง :min ถึง :max รายการ',
        'file' => ':attribute ต้องมีขนาดระหว่าง :min ถึง :max กิโลไบต์',
        'numeric' => ':attribute ต้องเป็นค่าระหว่าง :min ถึง :max',
        'string' => ':attribute ต้องมีความยาวระหว่าง :min ถึง :max ตัวอักษร',
    ],
    'boolean' => ':attribute ต้องเป็นค่า true หรือ false',
    'confirmed' => ':attribute ไม่ตรงกับการยืนยัน',
    'current_password' => 'รหัสผ่านไม่ถูกต้อง',
    'date' => ':attribute ต้องเป็นวันที่ที่ถูกต้อง',
    'date_equals' => ':attribute ต้องเป็นวันที่เท่ากับ :date',
    'date_format' => ':attribute ต้องตรงกับรูปแบบ :format',
    'decimal' => ':attribute ต้องมีทศนิยม :decimal ตำแหน่ง',
    'declined' => 'ต้องปฏิเสธ :attribute',
    'declined_if' => 'ต้องปฏิเสธ :attribute เมื่อ :other เป็น :value',
    'different' => ':attribute และ :other ต้องแตกต่างกัน',
    'digits' => ':attribute ต้องเป็นตัวเลข :digits หลัก',
    'digits_between' => ':attribute ต้องเป็นตัวเลขระหว่าง :min ถึง :max หลัก',
    'dimensions' => ':attribute มีขนาดภาพไม่ถูกต้อง',
    'distinct' => ':attribute มีค่าที่ซ้ำกัน',
    'doesnt_end_with' => ':attribute ต้องไม่ลงท้ายด้วยค่าใดค่าหนึ่งใน :values',
    'doesnt_start_with' => ':attribute ต้องไม่ขึ้นต้นด้วยค่าใดค่าหนึ่งใน :values',
    'email' => ':attribute ต้องเป็นที่อยู่อีเมลที่ถูกต้อง',
    'ends_with' => ':attribute ต้องลงท้ายด้วยค่าในรายการต่อไปนี้ :values',
    'enum' => ':attribute ที่เลือกได้ไม่ถูกต้อง',
    'exists' => ':attribute ที่เลือกไม่ถูกต้อง',
    'file' => ':attribute ต้องเป็นไฟล์',
    'filled' => ':attribute ต้องมีค่า',
    'gt' => [
        'array' => ':attribute ต้องมีรายการมากกว่า :value รายการ',
        'file' => ':attribute ต้องมีขนาดใหญ่กว่า :value กิโลไบต์',
        'numeric' => ':attribute ต้องมีค่ามากกว่า :value',
        'string' => ':attribute ต้องมีความยาวมากกว่า :value ตัวอักษร',
    ],
    'gte' => [
        'array' => ':attribute ต้องมีรายการ :value รายการหรือมากกว่า',
        'file' => ':attribute ต้องมีขนาดใหญ่กว่าหรือเท่ากับ :value กิโลไบต์',
        'numeric' => ':attribute ต้องมีค่ามากกว่าหรือเท่ากับ :value',
        'string' => ':attribute ต้องมีความยาวมากกว่าหรือเท่ากับ :value ตัวอักษร',
    ],
    'image' => ':attribute ต้องเป็นรูปภาพ',
    'in' => ':attribute ที่เลือกไม่ถูกต้อง',
    'in_array' => ':attribute ต้องอยู่ใน :other',
    'integer' => ':attribute ต้องเป็นจำนวนเต็ม',
    'ip' => ':attribute ต้องเป็นที่อยู่ IP ที่ถูกต้อง',
    'ipv4' => ':attribute ต้องเป็นที่อยู่ IPv4 ที่ถูกต้อง',
    'ipv6' => ':attribute ต้องเป็นที่อยู่ IPv6 ที่ถูกต้อง',
    'json' => ':attribute ต้องเป็นสตริง JSON ที่ถูกต้อง',
    'lowercase' => ':attribute ต้องเป็นตัวพิมพ์เล็ก',
    'lt' => [
        'array' => ':attribute ต้องมีรายการน้อยกว่า :value รายการ',
        'file' => ':attribute ต้องมีขนาดเล็กกว่า :value กิโลไบต์',
        'numeric' => ':attribute ต้องมีค่าน้อยกว่า :value',
        'string' => ':attribute ต้องมีความยาวน้อยกว่า :value ตัวอักษร',
    ],
    'lte' => [
        'array' => ':attribute ต้องไม่มีรายการมากกว่า :value รายการ',
        'file' => ':attribute ต้องมีขนาดเล็กกว่าหรือเท่ากับ :value กิโลไบต์',
        'numeric' => ':attribute ต้องมีค่าน้อยกว่าหรือเท่ากับ :value',
        'string' => ':attribute ต้องมีความยาวน้อยกว่าหรือเท่ากับ :value ตัวอักษร',
    ],
    'mac_address' => ':attribute ต้องเป็นที่อยู่ MAC ที่ถูกต้อง',
    'max' => [
        'array' => ':attribute ต้องไม่มีรายการมากกว่า :max รายการ',
        'file' => ':attribute ต้องไม่ใหญ่กว่า :max กิโลไบต์',
        'numeric' => ':attribute ต้องไม่ใหญ่กว่า :max',
        'string' => ':attribute ต้องไม่ยาวกว่า :max ตัวอักษร',
    ],
    'max_digits' => ':attribute ต้องไม่มีตัวเลขมากกว่า :max หลัก',
    'mimes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'mimetypes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'min' => [
        'array' => ':attribute ต้องมีรายการอย่างน้อย :min รายการ',
        'file' => ':attribute ต้องมีขนาดอย่างน้อย :min กิโลไบต์',
        'numeric' => ':attribute ต้องมีค่าอย่างน้อย :min',
        'string' => ':attribute ต้องมีความยาวอย่างน้อย :min ตัวอักษร',
    ],
    'min_digits' => ':attribute ต้องมีตัวเลขอย่างน้อย :min หลัก',
    'missing' => ':attribute ต้องไม่มี',
    'missing_if' => ':attribute ต้องไม่มีเมื่อ :other เป็น :value',
    'missing_unless' => ':attribute ต้องไม่มีเว้นแต่ :other เป็น :value',
    'missing_with' => ':attribute ต้องไม่มีเมื่อ :values มีอยู่',
    'missing_with_all' => ':attribute ต้องไม่มีเมื่อ :values มีอยู่',
    'multiple_of' => ':attribute ต้องเป็นจำนวนที่เป็นเท่าของ :value',
    'not_in' => ':attribute ที่เลือกไม่ถูกต้อง',
    'not_regex' => 'รูปแบบของ :attribute ไม่ถูกต้อง',
    'numeric' => ':attribute ต้องเป็นตัวเลข',
    'password' => [
        'letters' => ':attribute ต้องมีอย่างน้อยหนึ่งตัวอักษร',
        'mixed' => ':attribute ต้องประกอบด้วยตัวอักษรพิมพ์ใหญ่อย่างน้อยหนึ่งตัว และตัวอักษรพิมพ์เล็กอย่างน้อยหนึ่งตัว',
        'numbers' => ':attribute ต้องประกอบด้วยตัวเลขอย่างน้อยหนึ่งตัว',
        'symbols' => ':attribute ต้องประกอบด้วยสัญลักษณ์อย่างน้อยหนึ่งตัว',
        'uncompromised' => ':attribute ที่ระบุมีการรั่วไหลข้อมูล โปรดเลือก :attribute อื่น',
    ],
    'present' => ':attribute ต้องมีอยู่',
    'prohibited' => ':attribute ไม่ได้รับอนุญาต',
    'prohibited_if' => ':attribute ไม่ได้รับอนุญาตเมื่อ :other เป็น :value',
    'prohibited_unless' => ':attribute ไม่ได้รับอนุญาตเว้นแต่ :other อยู่ใน :values',
    'prohibits' => ':attribute ของคุณห้ามมีอยู่พร้อมกับ :other',
    'regex' => 'รูปแบบของ :attribute ไม่ถูกต้อง',
    'required' => 'ต้องระบุ :attribute',
    'required_array_keys' => ':attribute ต้องมีรายการสำหรับ: :values',
    'required_if' => 'ต้องระบุ :attribute เมื่อ :other เป็น :value',
    'required_if_accepted' => 'ต้องระบุ :attribute เมื่อยอมรับ :other',
    'required_unless' => 'ต้องระบุ :attribute เว้นแต่ :other อยู่ใน :values',
    'required_with' => 'ต้องระบุ :attribute เมื่อ :values มีอยู่',
    'required_with_all' => 'ต้องระบุ :attribute เมื่อ :values มีอยู่',
    'required_without' => 'ต้องระบุ :attribute เมื่อ :values ไม่มีอยู่',
    'required_without_all' => 'ต้องระบุ :attribute เมื่อไม่มี :values อยู่',
    'same' => ':attribute ต้องตรงกับ :other',
    'size' => [
        'array' => ':attribute ต้องประกอบด้วย :size รายการ',
        'file' => ':attribute ต้องมีขนาด :size กิโลไบต์',
        'numeric' => ':attribute ต้องมีค่าเป็น :size',
        'string' => ':attribute ต้องมีความยาว :size ตัวอักษร',
    ],
    'starts_with' => ':attribute ต้องขึ้นต้นด้วยค่าในรายการต่อไปนี้ :values',
    'string' => ':attribute ต้องเป็นสตริง',
    'timezone' => ':attribute ต้องเป็นโซนเวลาที่ถูกต้อง',
    'unique' => ':attribute ถูกใช้งานแล้ว',
    'uploaded' => 'ไม่สามารถอัปโหลด :attribute ได้',
    'uppercase' => ':attribute ต้องเป็นตัวพิมพ์ใหญ่',
    'url' => ':attribute ต้องเป็น URL ที่ถูกต้อง',
    'ulid' => ':attribute ต้องเป็น ULID ที่ถูกต้อง',
    'uuid' => ':attribute ต้องเป็น UUID ที่ถูกต้อง',

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

];
