<?php

return [
    'feeds' => [
        'main' => [
            'items' => 'App\Models\Post@getFeedItems',
            'url' => '/rss',

            'format' => 'rss',

            'title' => 'CodeFrenzies',
            'description' => 'A Personal Look into the World of Programming',
            'language' => 'en-US',
        ],
    ],
];
