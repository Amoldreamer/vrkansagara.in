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

$entry->setId('sample-post');
$entry->setTitle('New site!');
$entry->setAuthor($author);
$entry->setDraft(true);
$entry->setPublic(false);
$entry->setCreated(new DateTime('2004:01:14 23:27:27'));
$entry->setUpdated(new DateTime('2004:01:14 23:27:27'));
$entry->setTimezone('America/Chicago');
$entry->setTags([
    0 => 'draft',
    1 => 'php',
]);

$body = <<<'EOT'
<p>
    This is the principal body of the post, and will be shown everywhere.
</p>
EOT;
$entry->setBody($body);

$extended = <<<'EOT'
This is the extended portion of the entry, and is only shown in the main entry 
views.
EOT;
$entry->setExtended($extended);

return $entry;
