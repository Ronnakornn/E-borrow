<?php

return [

    'label' => 'การนำทางหน้า',

    'overview' => '{1} แสดง 1 รายการ|[2,*] แสดง :first ถึง :last จาก :total รายการ',

    'fields' => [

        'records_per_page' => [

            'label' => 'ต่อหน้า',

            'options' => [
                'all' => 'ทั้งหมด',
            ],

        ],

    ],

    'actions' => [

        'go_to_page' => [
            'label' => 'ไปที่หน้า :page',
        ],

        'next' => [
            'label' => 'ถัดไป',
        ],

        'previous' => [
            'label' => 'ก่อนหน้า',
        ],

    ],

];
