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
$entry->setTitle('Magento2 Directory Permission');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2017:08:11 23:27:27'));
$entry->setUpdated(new DateTime('2017:08:11 23:27:27'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['hello', 'world', 'php']);

$body = <<<'EOT'
Here is the quick developer permission for your magento root directory. Just go to your magento root directory and apply following commond using your terminal.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
~~~bash
find . -type f -exec chmod 644 {} \;

find . -type d -exec chmod 755 {} \;

find var/* -type d -exec chmod 777 {} \;

find pub/media/ -type d -exec chmod 777 {} \;

find pub/static/ -type d -exec chmod 777 {} \;

chmod 777 app/etc/*

chmod 0777 var -Rf

chmod 0777 pub/media/ -Rf

chmod 0777 pub/static/ -Rf

chmod 644 app/etc/*.xml

chown -R :vallabh .

chmod u+x bin/magento
~~~
EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
