<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => 'About Pakistan Properties - Buy Sell Rent Homes & Properties In Pakistan', // set false to total remove
            'titleBefore' => 'About Pakistan Properties - Buy Sell Rent Homes & Properties In Pakistan', // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'About Pakistan Properties, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.', // set false to total remove
            'separator' => ' - ',
            'keywords' => ['Pakistan property','properties in Pakistan'],
            'canonical' => null, // Set null for using Url::current(), set false to total remove
            'robots' => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => 'Pakistan Property Real Estate - Sell Buy Rent Homes & Properties In Pakistan', // set false to total remove
            'description' => 'About Pakistan Properties, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.', // set false to total remove
            'url' => null, // Set null for using Url::current(), set false to total remove
            'type' => false,
            'site_name' => 'property.aboutpakistan.com',
            'images' => [''],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => 'false', // set false to total remove
            'description' => 'false', // set false to total remove
            'url' => false, // Set null for using Url::current(), set false to total remove
            'type' => 'false',
            'images' => [],
        ],
    ],
];
