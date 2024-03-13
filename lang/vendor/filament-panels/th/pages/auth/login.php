<?php

return [

    'title' => 'เข้าสู่ระบบ',

    'heading' => 'ลงชื่อเข้าใช้',

    'actions' => [

        'register' => [
            'before' => 'หรือ',
            'label' => 'ลงทะเบียนบัญชี',
        ],

        'request_password_reset' => [
            'label' => 'ลืมรหัสผ่าน?',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'อีเมล',
        ],

        'password' => [
            'label' => 'รหัสผ่าน',
        ],

        'remember' => [
            'label' => 'จดจำการเข้าสู่ระบบไว้',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'ลงชื่อเข้าใช้',
            ],

        ],

    ],

    'messages' => [

        'failed' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'มีการพยายามเข้าสู่ระบบมากเกินไป',
            'body' => 'โปรดลองอีกครั้งใน :seconds วินาที',
        ],

    ],

];
