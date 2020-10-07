<?php

/**
 * This is a sample "local" configuration for your application. To use it, copy
 * it to your config/autoload/ directory of your application, and edit to suit
 * your application.
 *
 * This configuration example demonstrates using an SMTP mail transport, a
 * ReCaptcha CAPTCHA adapter, and setting the to and sender addresses for the
 * mail message.
 */

use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Captcha\Dumb;
use Laminas\Mail\Transport\File;

return [
    'phly-simple-page' => [
        'cache' => [
            'adapter' => [
                'name' => Filesystem::class,
                'options' => [
                    'namespace' => 'pages',
                    'cache_dir' => getcwd() . '/data/cache',
                    'dir_permission' => '0777',
                    'file_permission' => '0666',
                ],
            ],
        ],
    ],
    'phly_contact' => [
        // This is simply configuration to pass to Laminas\Captcha\Factory
        'captcha' => [
            'class' => Dumb::class,
            'options' => [
                'pubkey' => 'RECAPTCHA_PUBKEY_HERE',
                'privkey' => 'RECAPTCHA_PRIVKEY_HERE',
            ],
        ],

        // This sets the default "to" and "sender" headers for your message
        'message' => [
            /*
            // These can be either a string, or an array of email => name pairs
            'to'     => 'contact@your.tld',
            'from'   => 'contact@your.tld',
            // This should be an array with minimally an "address" element, and
            // can also contain a "name" element
            'sender' => array(
                'address' => 'contact@your.tld'
            ),
             */
        ],

        // Transport consists of two keys:
        // - "class", the mail tranport class to use, and
        // - "options", any options to use to configure the
        //   tranpsort. Usually these will be passed to the
        //   transport-specific options class
        // This example configures GMail as your SMTP server
        'mail_transport' => [
//            'class'   => Smtp::class,
//            'options' => [
//                'host'             => 'smtp.gmail.com',
//                'port'             => 587,
//                'connectionClass'  => 'login',
//                'connectionConfig' => [
//                    'ssl'      => 'tls',
//                    'username' => 'contact@your.tld',
//                    'password' => 'password',
//                ],
//            ],

            'class' => File::class,
            'options' => [
                'path' => 'data/mail/',
            ],
        ],
    ],
    'blog' => [
        'options' => [
            'author_feed_filename_template' => 'public/blog/author/%s-%s.xml',
            'author_feed_title_template'    => 'Author: %s',
            'by_author_filename_template'   => 'public/blog/author/%s-p%d.html',
            'by_day_filename_template'      => 'public/blog/day/%s-p%d.html',
            'by_month_filename_template'    => 'public/blog/month/%s-p%d.html',
            'by_tag_filename_template'      => 'public/blog/tag/%s-p%d.html',
            'by_year_filename_template'     => 'public/blog/year/%s-p%d.html',
            'entries_filename_template'     => 'public/blog-p%d.html',
            'entries_template'              => 'phly-blog/list',
            'entry_filename_template'       => 'public/blog/%s.html',
            'entry_link_template'           => '/blog/%s.html',
            'entry_template'                => 'phly-blog/entry',
            'feed_author_email'             => 'you@your.tld',
            'feed_author_name'              => "Your name here",
            'feed_author_uri'               => 'http://your.tld',
            'feed_filename'                 => 'public/blog-%s.xml',
            'feed_hostname'                 => 'http://your.tld',
            'feed_title'                    => 'Blog Entries',
            'tag_feed_filename_template'    => 'public/blog/tag/%s-%s.xml',
            'tag_feed_title_template'       => 'Tag: %s',
            'tag_cloud_options'             => ['tagDecorator'              => [
                'decorator' => 'html_tag',
                'options'   => [
                    'fontSizeUnit' => '%',
                    'minFontSize'  => 80,
                    'maxFontSize'  => 300,
                ],
            ]],
        ],
        'posts_path'     => 'data/blog/',
        'view_callback'  => 'PhlyBlog\Module::prepareCompilerView',
        'cloud_callback' => false,
    ],
    'router' => [
        'routes' => [
            'phly-blog' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/blog',
                ],
                'may_terminate' => false,
                'child_routes'  => [
                    'index' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '.html',
                        ],
                    ],
                    'feed-atom' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '-atom.xml',
                        ],
                    ],
                    'feed-rss' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '-rss.xml',
                        ],
                    ],
                    'entry' => [
                        'type'    => 'Regex',
                        'options' => [
                            'regex' => '/(?<id>[^/]+)\.html',
                            'spec' => '/%id%.html',
                        ],
                    ],
                    'author' => [
                        'type'    => 'Regex',
                        'options' => [
                            'regex' => '/author/(?<author>[^/]+)',
                            'defaults' => [
                                'action'     => 'author',
                            ],
                            'spec' => '/author/%author%',
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'page' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '.html',
                                ],
                            ],
                            'feed-atom' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route' => '-atom.xml',
                                ],
                            ],
                            'feed-rss' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route' => '-rss.xml',
                                ],
                            ],
                        ],
                    ],
                    'tag' => [
                        'type'    => 'Regex',
                        'options' => [
                            'regex' => '/tag/(?<tag>[^/.-]+)',
                            'defaults' => [
                                'action'     => 'tag',
                            ],
                            'spec' => '/tag/%tag%',
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'page' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '.html',
                                ],
                            ],
                            'feed-atom' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route' => '-atom.xml',
                                ],
                            ],
                            'feed-rss' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route' => '-rss.xml',
                                ],
                            ],
                        ],
                    ],
                    'year' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route' => '/year/:year.html',
                            'constraints' => [
                                'year' => '\d{4}',
                            ],
                            'defaults' => [
                                'action'     => 'year',
                            ],
                        ],
                    ],
                    'month' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route' => '/month/:year/:month.html',
                            'constraints' => [
                                'year'  => '\d{4}',
                                'month' => '\d{2}',
                            ],
                            'defaults' => [
                                'action'     => 'month',
                            ],
                        ],
                    ],
                    'day' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route' => '/day/:year/:month/:day.html',
                            'constraints' => [
                                'year'  => '\d{4}',
                                'month' => '\d{2}',
                                'day'   => '\d{2}',
                            ],
                            'defaults' => [
                                'action'     => 'day',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'console' => [
        'router' => ['routes' => [
            'phly-blog-compile' => [
                'type'    => 'Simple',
                'options' => [
                    'route' => 'blog compile [--all|-a] [--entries|-e] [--archive|-c] [--year|-y] [--month|-m] [--day|-d] [--tag|-t] [--author|-r]',
                    'defaults' => [
                        'controller' => 'PhlyBlog\CompileController',
                        'action'     => 'compile',
                    ],
                ],
            ],
        ]],
    ],
];
