<?php

use Blog\AuthorEntity;
use Blog\EntryEntity;

$entry  = new EntryEntity();
$author = new AuthorEntity();
$author->fromArray([
  'id' => 'jdoe',
  'name' => 'John Doe',
  'email' => 'john@doe.com',
  'url' => 'http://john.doe.com',
]);

$entry->setId('4f8706cf65b81-post-name');
$entry->setTitle('4f8706cf65b81 Post');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2005:04:01 21:15:15'));
$entry->setUpdated(new DateTime('2005:04:01 21:15:15'));
$entry->setTimezone('America/Chicago');
$entry->setTags([
  0 => 'draft',
]);

$body = <<<'EOT'
This is it!
EOT;
$entry->setBody($body);

$extended = <<<'EOT'
This is the extended portion of the entry.
EOT;
$entry->setExtended($extended);

return $entry;
