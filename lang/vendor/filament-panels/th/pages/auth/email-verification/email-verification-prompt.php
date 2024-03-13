<?php

return [

    'title' => 'ยืนยันอีเมลของคุณ',

    'heading' => 'ยืนยันอีเมลของคุณ',

    'actions' => [

        'resend_notification' => [
            'label' => 'ส่งอีกครั้ง',
        ],

    ],

    'messages' => [
        'notification_not_received' => 'ยังไม่ได้รับอีเมลที่เราส่ง?',
        'notification_sent' => 'เราได้ส่งอีเมลไปที่ :email ซึ่งมีคำแนะนำเกี่ยวกับวิธีการยืนยันอีเมลของคุณ',
    ],

    'notifications' => [

        'notification_resent' => [
            'title' => 'เราได้ส่งอีเมลอีกครั้ง',
        ],

        'notification_resend_throttled' => [
            'title' => 'มีการพยายามส่งอีกครั้งมากเกินไป',
            'body' => 'โปรดลองอีกครั้งใน :seconds วินาที',
        ],

    ],

];
