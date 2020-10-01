<?php

return [
    'tables' => [
        'posts' => [
            [
                'name' => 'id',
                'type' => 'int(11)',
                'primary_key' => true,
                'attributes' => '',
                'is_null' =>  false,
                'default' => ''
            ],
            [
                'name' => 'title',
                'type' => 'varchar(255)',
                'primary_key' => false,
                'attributes' => '',
                'is_null' =>  false,
                'default' => ''
            ],
            [
                'name' => 'date',
                'type' => 'TIMESTAMP',
                'primary_key' => false,
                'attributes' => '',
                'is_null' =>  false,
                'default' => 'CURRENT_TIMESTAMP'
            ],
            [
                'name' => 'text',
                'type' => 'varchar(255)',
                'primary_key' => false,
                'attributes' => '',
                'is_null' =>  false,
                'default' => ''
            ]
        ], 
        'users' => [
            [
                'name' => 'id',
                'type' => 'int(11)',
                'primary_key' => true,
                'attributes' => '',
                'is_null' =>  false,
                'default' => ''
            ],
            [
                'name' => 'username',
                'type' => 'varchar(255)',
                'primary_key' => false,
                'attributes' => '',
                'is_null' =>  false,
                'default' => ''
            ],
            [
                'name' => 'password',
                'type' => 'varchar(255)',
                'primary_key' => false,
                'attributes' => '',
                'is_null' =>  false,
                'default' => ''
            ],
            [
                'name' => 'email',
                'type' => 'varchar(255)',
                'primary_key' => false,
                'attributes' => '',
                'is_null' =>  false,
                'default' => ''
            ]
        ]
    ],
];