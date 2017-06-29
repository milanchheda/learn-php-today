<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Learn PHP Today", // set false to total remove
            'description'  => 'LearnPHPToday is a website for developers to read news and feeds related to PHP, Laravel, Symfony and everything related to PHP. Learn something new everyday.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['Learn PHP Today', 'Learn PHP', 'PHP', 'PHP7', 'PHP News', 'Laravel', 'PHP Today', 'Symfony'],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Learn PHP Today', // set false to total remove
            'description' => 'LearnPHPToday is a website for developers to read news and feeds related to PHP, Laravel, Symfony and everything related to PHP. Learn something new everyday.', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          'site'        => '@learn_php_today',
        ],
    ],
];
