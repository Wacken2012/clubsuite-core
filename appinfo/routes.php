<?php

return [
    'routes' => [
        ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
        
        // API Routes
        ['name' => 'member_api#index', 'url' => '/members', 'verb' => 'GET'],
        ['name' => 'member_api#show', 'url' => '/members/{id}', 'verb' => 'GET'],
        ['name' => 'member_api#create', 'url' => '/members', 'verb' => 'POST'],
        ['name' => 'member_api#update', 'url' => '/members/{id}', 'verb' => 'PUT'],
        ['name' => 'member_api#destroy', 'url' => '/members/{id}', 'verb' => 'DELETE'],
    ],
];
