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
$entry->setCreated(new DateTime('2020:11:28 07:46:00'));
$entry->setUpdated(new DateTime('2020:11:28 07:46:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['freebsd', 'shell']);

$body = <<<'EOT'
Hello FreeBSD

![Hello FreeBSD](/assets/images/blog/FreeBSD/logo.png)

I am starting this series using Facebook page at[AskFreeBSD](https://www.facebook.com/AskFreeBSD). 

EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'

This is not official page by FreeBSD, But I am trying to provide best knowledge of what `FreeBSD` is how it help to you and your goal.

![FreeBSD](/assets/images/blog/FreeBSD/logo-red.png)


EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
