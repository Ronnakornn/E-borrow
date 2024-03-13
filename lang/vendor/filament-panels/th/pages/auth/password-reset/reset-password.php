<?php

return [

    'title' => 'รีเซ็ตรหัสผ่านของคุณ',

    'heading' => 'รีเซ็ตรหัสผ่านของคุณ',

    'form' => [

        'email' => [
            'label' => 'อีเมล',
        ],

        'password' => [
            'label' => 'รหัสผ่าน',
            'validation_attribute' => 'รหัสผ่าน',
        ],

        'password_confirmation' => [
            'label' => 'ยืนยันรหัสผ่าน',
        ],

        'actions' => [

            'reset' => [
                'label' => 'รีเซ็ตรหัสผ่าน',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'มีการลองรีเซ็ตรหัสผ่านมากเกินไป',
            'body' => 'โปรดลองอีกครั้งใน :seconds วินาที',
        ],

    ],

];
