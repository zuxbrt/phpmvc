<?php

return [
    'tables' => [
        'posts' => [
            [
                'name' => 'id',
                'type' => 'int(11)',
                'is_auto_increment' => false,
                'attributes' => '',
                'is_null' =>  'NOT NULL',
                'default' => ''
            ],
            [
                'name' => 'title',
                'type' => 'varchar(255)',
                'is_auto_increment' => false,
                'attributes' => '',
                'is_null' =>  'NOT NULL',
                'default' => ''
            ],
            [
                'name' => 'date',
                'type' => 'timestamp(6)',
                'is_auto_increment' => false,
                'attributes' => '',
                'is_null' =>  'NOT NULL',
                'default' => ''
            ],
            [
                'name' => 'text',
                'type' => 'varchar(255)',
                'is_auto_increment' => false,
                'attributes' => '',
                'is_null' =>  'NOT NULL',
                'default' => ''
            ]
        ]
    ],
];