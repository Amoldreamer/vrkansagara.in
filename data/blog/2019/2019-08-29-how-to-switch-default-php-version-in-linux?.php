<?php

use PhlyBlog\AuthorEntity;
use PhlyBlog\EntryEntity;

$entry  = new EntryEntity();
$author = new AuthorEntity();
$author->fromArray([
    'id'    => 'vrkansagara',
    'name'  => 'Vallabh Kansagara',
    'email' => 'vrkansagara@gmail.com',
    'url'   => 'https://vrkansagara.in',
]);

$entry->setId(pathinfo(__FILE__, PATHINFO_FILENAME));
$entry->setTitle(str_replace('-', ' ', ucfirst(substr($entry->getId(), 11))));
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2019:08:29 16:33:48'));
$entry->setUpdated(new DateTime('2019:08:29 16:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['php','linux']);

$body = <<<'EOT'
### Problem :- How to switch default php version in linux ?
### Platfom :- Linux
### Solutions 

Check which php versions are available with system 

~~~bash
    sudo update-alternatives --config php
~~~
EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'
or else you can use following command to set each library
~~~bash
    sudo update-alternatives --set php /usr/bin/php7.2
    sudo update-alternatives --set phar /usr/bin/phar7.2
    sudo update-alternatives --set phar.phar /usr/bin/phar.phar7.2
    sudo update-alternatives --set phpize /usr/bin/phpize7.2
    sudo update-alternatives --set php-config /usr/bin/php-config7.2
~~~


Ff still not able to set the default version than look for the `$PATH` for more details and check weather this directory has conflicts with existing binary or not.

~~~bash
    cat $PATH
~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
