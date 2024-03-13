<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'ชื่อ',
    'column.guard_name' => 'Guard Name',
    'column.roles' => 'บทบาท',
    'column.permissions' => 'สิทธิ์',
    'column.updated_at' => 'แก้ไขล่าสุด',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'ชื่อ',
    'field.guard_name' => 'Guard Name',
    'field.permissions' => 'สิทธิ์',
    'field.select_all.name' => 'เลือกทั้งหมด',
    'field.select_all.message' => 'เปิดใช้สิทธิ์ทั้งหมดที่ <span class="text-primary font-medium">เปิดใช้งาน</span> ในขณะนี้สำหรับบทบาทนี้',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'บทบาท & สิทธิ์',
    'nav.role.label' => 'บทบาท',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'บทบาท',
    'resource.label.roles' => 'บทบาท',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Entities',
    'resources' => 'Resources',
    'widgets' => 'Widgets',
    'pages' => 'Pages',
    'custom' => 'Custom Permissions',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'คุณไม่ได้รับอนุญาตให้เข้าถึง',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'View',
        'view_any' => 'View Any',
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'delete_any' => 'Delete Any',
        'force_delete' => 'Force Delete',
        'force_delete_any' => 'Force Delete Any',
        'restore' => 'Restore',
        'reorder' => 'Reorder',
        'restore_any' => 'Restore Any',
        'replicate' => 'Replicate',
    ],
];
