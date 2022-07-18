<?php

use App\Models\User;

return [
    'admin' => new User([
        'email' => env('ADMIN_EMAIL', 'test@example.com'),
        'first_name' => env('ADMIN_FIRST_NAME', 'Test Name'),
        'last_name' => env('ADMIN_LAST_NAME', 'Test Surname'),
        'username' => 'ps-admin',
        'phone_number' => env('ADMIN_PHONE', '0999999999'),
        'address' => env('ADMIN_ADDRESS', 'Test Address'),
        'password' => password_hash(env('ADMIN_PASSWORD', 'secret'), PASSWORD_BCRYPT),
    ]),
    'allowed_date_range' => [
        'max' => date('Y-m-d', strtotime('-70 years')),
        'min' => date('Y-m-d', strtotime('-18 years')),
    ],
    'assignment' => [
        'number_of_guards_per_ward' => 2
    ]
];
