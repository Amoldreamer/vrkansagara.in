<?php

use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Captcha\Dumb;
use Laminas\Mail\Transport\File;
use Laminas\Router\Http\Literal;

return [
    'disqus' => [
        'key'         => 'vrkansagara',
        'development' => 0,
    ],
    'blog' => [
        'options' => [
            // The following indicate where to write files. Note that this
            // configuration writes to the "public/" directory, which would
            // create a blog made from static files. For the various
            // paginated views, "%d" is the current page number; "%s" is
            // typically a date string (see below for more information) or tag.

            'by_day_filename_template' => 'public/blog/day/%s-p%d.html',
            'by_month_filename_template' => 'public/blog/month/%s-p%d.html',
            'by_tag_filename_template' => 'public/blog/tag/%s-p%d.html',
            'by_year_filename_template' => 'public/blog/year/%s-p%d.html',
            'entries_filename_template' => 'public/blog/index-p%d.html',

            // In this case, the "%s" is the entry ID.
            'entry_filename_template' => 'public/blog/%s.html',

            // For feeds, the final "%s" is the feed type -- "atom" or "rss". In
            // the case of the tag feed, the initial "%s" is the current tag.
            'feed_filename' => 'public/blog/feed-%s.xml',
            'tag_feed_filename_template' => 'public/blog/tag/%s-%s.xml',

            // This is the link to a blog post
            'entry_link_template' => '/blog/%s.html',

            // These are the various URL templates for "paginated" views. The
            // "%d" in each is the current page number.
            'entries_url_template' => '/blog/index-p%d.html',
            // For the year/month/day paginated views, "%s" is a string
            // representing the date. By default, this will be "YYYY",
            // "YYYY/MM", and "YYYY/MM/DD", respectively.
            'by_year_url_template' => '/blog/year/%s-p%d.html',
            'by_month_url_template' => '/blog/month/%s-p%d.html',
            'by_day_url_template' => '/blog/day/%s-p%d.html',

            // These are the primary templates you will use -- the first is for
            // paginated lists of entries, the second for individual entries.
            // There are of course more templates, but these are the only ones
            // that will be directly referenced and rendered by the compiler.
            'entries_template' => 'blog/list',
            'entry_template' => 'blog/entry',

            // The feed author information is default information to use when
            // the author of a post is unknown, or is not an AuthorEntity
            // object (and hence does not contain this information).
            'feed_author_email' => 'vrkansagara@gmail.com',
            'feed_author_name' => 'Vallabh Kansagara (VRKANSAGARA)',
            'feed_author_uri' => 'https://vrkansagara.in/',
            'feed_hostname' => 'https://vrkansagara.in',
            'feed_title' => 'Blog Entries - Vallabh Kansagara(VRKANSAGARA) Blog',
            'tag_feed_title_template' => 'Tag: %s - Vallabh Kansagara(VRKANSAGARA) Blog',


            'author_feed_filename_template' => 'public/blog/author/%s-%s.xml',
            'author_feed_title_template' => 'Author: %s - Vallabh Kansagara(VRKANSAGARA) Blog',
            'by_author_filename_template' => 'public/blog/author/%s-p%d.html',

            // If generating a tag cloud, you can specify options for
            // Laminas\Tag\Cloud. The following sets up percentage sizing from
            // 80-300%
            'tag_cloud_options' => [
                'tagDecorator' => [
                    'decorator' => 'html_tag',
                    'options' => [
                        'fontSizeUnit' => '%',
                        'minFontSize' => 80,
                        'maxFontSize' => 300,
                    ],
                ]],
        ],
        // This is the location where you are keeping your post files (the PHP
        // files returning `PhlyBlog\EntryEntity` objects).
        'posts_path' => 'data/blog/',

        // Tag cloud generation is possible, but you likely need to capture
        // the rendered cloud to inject elsewhere. You can do this with a
        // callback.
        // The callback will receive a Laminas\Tag\Cloud instance, the View
        // instance, application configuration // (as an array), and the
        // application's Locator instance.
        'cloud_callback' => ['Application\Module', 'handleTagCloud'],
    ],
    'router' => [
        'routes' => [
            'blog' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/blog',
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'index' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/index.html',
                        ],
                    ],
                    'feed-atom' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/feed-atom.xml',
                        ],
                    ],
                    'feed-rss' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/feed-rss.xml',
                        ],
                    ],
                ],
            ]
        ],
    ],
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
];
