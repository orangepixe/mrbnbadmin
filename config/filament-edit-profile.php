<?php

return [
    'show_custom_fields' => false,
    'avatar_column' => 'avatar',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public', // or replace by filesystem disk visibility with fallback value
    'custom_fields' => []
];
