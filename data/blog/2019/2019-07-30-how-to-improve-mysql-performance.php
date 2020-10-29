<?php

use PhlyBlog\AuthorEntity;
use PhlyBlog\EntryEntity;

$entry = new EntryEntity();
$author = new AuthorEntity();
$author->fromArray([
    'id' => 'vrkansagara',
    'name' => 'Vallabh Kansagara',
    'email' => 'vrkansagara@gmail.com',
    'url' => 'https://vrkansagara.in',
]);

$entry->setId(pathinfo(__FILE__, PATHINFO_FILENAME));
$entry->setTitle('How to improve mysql performance?');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2019:07:07 19:33:48'));
$entry->setUpdated(new DateTime('2019:07:07 19:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['linux', 'mysql', 'performance']);

$body = <<<'EOT'
There are various kind of improvement are available to tweek the mysql configuration to improve and measure how to improve but few of my favorites tips are noted here.
EOT;

$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
#### For string columns, MySQL indexes the left side of a string. That means an index can speed a like query that has a wildcard on the right side:

> ## SELECT * FROM users WHERE email LIKE "@gmail.com%"

### This will be faster with an index column
EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
