<?php

return [

    'title' => 'ลงทะเบียน',

    'heading' => 'ลงทะเบียน',

    'actions' => [

        'login' => [
            'before' => 'หรือ',
            'label' => 'เข้าสู่ระบบด้วยบัญชีของคุณ',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'อีเมล',
        ],

        'name' => [
            'label' => 'ชื่อ',
        ],

        'password' => [
            'label' => 'รหัสผ่าน',
            'validation_attribute' => 'รหัสผ่าน',
        ],

        'password_confirmation' => [
            'label' => 'ยืนยันรหัสผ่าน',
        ],

        'actions' => [

            'register' => [
                'label' => 'ลงทะเบียน',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'มีการพยายามลงทะเบียนมากเกินไป',
            'body' => 'โปรดลองอีกครั้งใน :seconds วินาที',
        ],

    ],

];
