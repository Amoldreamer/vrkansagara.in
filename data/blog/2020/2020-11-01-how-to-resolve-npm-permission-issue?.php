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
$entry->setCreated(new DateTime('2020:11:01 23:59:00'));
$entry->setUpdated(new DateTime('2020:11:01 23:59:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['npm', 'linux']);

$body = <<<'EOT'
This is general solutions for all kind of `npm ` permission issue.

~~~bash
sudo chown -R $USER ~/.npm
sudo chown -R  $USER /usr/bin/npm
sudo chown -R  $USER /usr/lib/node_modules/
chmod -R a+x node_modules
~~~

EOT;
$entry->setBody(convertMarkdownToHtml($body));

//$extended = <<<'EOT'
//EOT;
//$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
