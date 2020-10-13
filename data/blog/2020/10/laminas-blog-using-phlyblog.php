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

$entry->setId('laminas-blog-using-phlyblog');
$entry->setTitle('Welcome back to the Static blog generation using PhlyBlog');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2020:10:13 21:37:00'), new DateTimeZone('Asia/Kolkata'));
$entry->setUpdated(new DateTime('2020:10:13 21:37:00'), new DateTimeZone('Asia/Kolkata'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['hello', 'laminas', 'PhlyBlog']);

$body = <<<'EOT'

I have started this website in late <b>2015-07-23T17:16:23Z</b>, around it took me around <b>5 years 2 months 21 days</b>  while writing this post. 

After very long time I am back with my favourite choice of module to work with PhlyBlog as my main choice of blogging platform.

* Item 1
* Item 2
  * Item 2a
  * Item 2b
EOT;
$entry->setBody($body);

$extended = <<<'EOT'
This is my fist blog post entry.
EOT;
$entry->setExtended($extended);

return $entry;
