<?php

return [

    'column_toggle' => [

        'heading' => 'คอลัมน์',

    ],

    'columns' => [

        'text' => [
            'more_list_items' => 'และอีก :count รายการ',
        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'เลือก/ยกเลิกการเลือกรายการทั้งหมดสำหรับการดำเนินการแบบกลุ่ม',
        ],

        'bulk_select_record' => [
            'label' => 'เลือก/ยกเลิกการเลือกรายการ :key สำหรับการดำเนินการแบบกลุ่ม',
        ],

        'search' => [
            'label' => 'ค้นหา',
            'placeholder' => 'ค้นหา',
            'indicator' => 'ค้นหา',
        ],

    ],

    'summary' => [

        'heading' => 'สรุป',

        'subheadings' => [
            'all' => ':labelทั้งหมด ',
            'group' => 'สรุป :group',
            'page' => 'หน้านี้',
        ],

        'summarizers' => [

            'average' => [
                'label' => 'เฉลี่ย',
            ],

            'count' => [
                'label' => 'นับ',
            ],

            'sum' => [
                'label' => 'รวม',
            ],

        ],

    ],

    'actions' => [

        'disable_reordering' => [
            'label' => 'เสร็จสิ้นการจัดเรียงลำดับรายการ',
        ],

        'enable_reordering' => [
            'label' => 'จัดเรียงลำดับรายการ',
        ],

        'filter' => [
            'label' => 'กรอง',
        ],

        'group' => [
            'label' => 'กลุ่ม',
        ],

        'open_bulk_actions' => [
            'label' => 'การดำเนินการแบบกลุ่ม',
        ],

        'toggle_columns' => [
            'label' => 'เปิด/ปิดคอลัมน์',
        ],

    ],

    'empty' => [

        'heading' => 'ไม่มี :model',

        'description' => 'เพิ่ม :model เพื่อเริ่มต้น',

    ],

    'filters' => [

        'actions' => [

            'remove' => [
                'label' => 'ลบตัวกรอง',
            ],

            'remove_all' => [
                'label' => 'ลบตัวกรองทั้งหมด',
                'tooltip' => 'ลบตัวกรองทั้งหมด',
            ],

            'reset' => [
                'label' => 'รีเซ็ต',
            ],

        ],

        'heading' => 'ตัวกรอง',

        'indicator' => 'ตัวกรองที่ใช้งานอยู่',

        'multi_select' => [
            'placeholder' => 'ทั้งหมด',
        ],

        'select' => [
            'placeholder' => 'ทั้งหมด',
        ],

        'trashed' => [

            'label' => 'รายการ',

            'only_trashed' => 'เฉพาะรายการที่ถูกลบ',

            'with_trashed' => 'รายการทั้งหมด',

            'without_trashed' => 'เฉพาะรายการที่ไม่ถูกลบ',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'จัดกลุ่มตาม',
                'placeholder' => 'จัดกลุ่มตาม',
            ],

            'direction' => [

                'label' => 'ทิศทางการจัดกลุ่ม',

                'options' => [
                    'asc' => 'เรียงจากน้อยไปมาก',
                    'desc' => 'เรียงจากมากไปน้อย',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'ลากและวางรายการเพื่อจัดเรียงลำดับ',

    'selection_indicator' => [

        'selected_count' => '1 รายการที่เลือก|:count รายการที่เลือก',

        'actions' => [

            'select_all' => [
                'label' => 'เลือกทั้งหมด :count',
            ],

            'deselect_all' => [
                'label' => 'ยกเลิกการเลือกทั้งหมด',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'เรียงลำดับโดย',
            ],

            'direction' => [

                'label' => 'ทิศทางการเรียงลำดับ',

                'options' => [
                    'asc' => 'เรียงจากน้อยไปมาก',
                    'desc' => 'เรียงจากมากไปน้อย',
                ],

            ],

        ],

    ],

];
