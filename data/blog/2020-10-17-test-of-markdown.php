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
$entry->setTitle('Testing of markdown');
$entry->setAuthor($author);
$entry->setDraft(true);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2020:10:17 09:05:00'));
$entry->setUpdated(new DateTime('2020:10:17 09:05:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['test', 'markdown']);

$body = <<<'EOT'
### Try _CommonMark_

You can try CommonMark here.  This dingus is powered by
[commonmark.js](https://github.com/jgm/commonmark.js), the
**JavaScript reference implementation.**

~~~bash
    1. item one
    2. item two
       - sublist
       - sublist
~~~
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
#### ------
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
