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
$entry->setTitle('sudo command with no password in linux!');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2019:09:09 16:33:48'));
$entry->setUpdated(new DateTime('2019:09:09 16:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['linux','git']);

$body = <<<'EOT'
How to avoid reputations of sudo command in linux.

Just follow bellow steps to avoid reputations.


Create file or edit if exist

~~~bash
sudo visudo -f /etc/sudoers.d/90-cloudimg-ubuntu
~~~
EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'
Change username as per your suite

~~~bash
# ubuntu user is default user in cloud-images.
# It needs passwords less sudo functionality.
ubuntu ALL=(ALL) NOPASSWD:ALL
~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
