<?php

use PhlyBlog\AuthorEntity;
use PhlyBlog\EntryEntity;

$entry  = new EntryEntity();
$author = new AuthorEntity();
$author->fromArray(array (
    'id'    => 'vrkansagara',
    'name'  => 'Vallabh Kansagara',
    'email' => 'vrkansagara@gmail.com',
    'url'   => 'https://vrkansagara.in',
));

$entry->setId('hello-world');
$entry->setTitle('hello world');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2015:01:01 23:27:27'));
$entry->setUpdated(new DateTime('2015:01:01 23:27:27'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(array (
  0 => 'hello',
  1 => 'world',
  2 => 'php',
));

$body =<<<'EOT'
Hello World.
EOT;
$entry->setBody($body);

$extended =<<<'EOT'
This is my fist blog post entry.
EOT;
$entry->setExtended($extended);

return $entry;
