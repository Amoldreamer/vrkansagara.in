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
$entry->setTitle('how to replace content in large file?');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2020:03:01 23:59:00'));
$entry->setUpdated(new DateTime('2020:03:01 23:59:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['mysql', 'files','large','vim']);

$body = <<<'EOT'
Many time developer just need to replace a bit of text inside the large file like  `*.sql` or `*.sqlite`  
Opening a file into editor take too much resource of system or server. So I come up with the very easy and useful
way to replace content into large file using linux command like. `sed` command.

Here I am taking an example of `MySql` file which having `*.sql` as file extension

~~~bash
sed -i '' 's/utf8mb4_0900_ai_ci/utf8mb4_unicode_ci/g'
~~~

EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
or

~~~bash
sed -i 's/utf8mb4_0900_ai_ci/utf8mb4_unicode_ci/g'
~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
