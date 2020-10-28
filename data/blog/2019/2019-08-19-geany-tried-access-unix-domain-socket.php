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
$entry->setTitle('Geany tried to access the unix domain socket of another instance running as another user');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2019:08:19 16:33:48'));
$entry->setUpdated(new DateTime('2019:08:19 16:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['linux']);

$body = <<<'EOT'
Problem :- `Geany tried to access the unix domain socket of another instance running as another user`


Run bellow command which resolve your issue.
~~~bash
    sudo -H rm ~/.config/geany/geany_socket_*
~~~

EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'
Problem :- `Configuration directory could not be created (Permission denied).
There could be some problems using Geany without a configuration directory.
Start Geany anyway?`


Run bellow command which resolve your issue.
~~~bash
   sudo chown $(whoami)  -Rf ~/.config/geany
~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
