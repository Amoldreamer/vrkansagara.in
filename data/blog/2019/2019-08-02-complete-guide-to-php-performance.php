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
$entry->setTitle(str_replace('-', ' ', ucfirst(substr($entry->getId(), 11))));
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2019:08:02 19:33:48'));
$entry->setUpdated(new DateTime('2019:08:02 19:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['linux', 'php', 'performance']);

$body = <<<'EOT'
I have a list of server config , tweaks and tricks for improving php performance.  
(1) A one-page opcache status page [GitHub Link  ](https://github.com/rlerdorf/opcache-status) [Direct download ](https://raw.githubusercontent.com/rlerdorf/opcache-status/master/opcache.php)
EOT;

$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
