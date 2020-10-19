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
$entry->setTitle('Sample Post');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(false);
$entry->setCreated(new DateTime('2028:01:01 23:27:27'));
$entry->setUpdated(new DateTime('2028:01:01 23:27:27'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['hello', 'world', 'php']);

$body = <<<'EOT'
Hello World.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
This is my fist blog post entry.

* Item 1
* Item 2
  * Item 2a
  * Item 2b
EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
