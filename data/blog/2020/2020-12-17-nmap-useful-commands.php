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
$entry->setTitle('Nmap useful commands');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2020:12:17 23:59:00'));
$entry->setUpdated(new DateTime('2020:12:17 23:59:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['network', 'linux', 'shell']);

$body = <<<'EOT'
Look up which ip is used by which host

~~~bash
nmap -sn 192.168.1.0/24
~~~
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'



EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
