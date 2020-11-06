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
$entry->setCreated(new DateTime('2019:09:23 16:33:48'));
$entry->setUpdated(new DateTime('2019:11:06 09:11:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags([
    'linux'
]);

$body = <<<'EOT'
## Kill any process using port

### `USE THIS COMMAND ON YOUR OWN RISK !`

~~~bash
sudo kill -9 $(sudo lsof -t -i:4200)
~~~~

If you want to check that if process running than and than kill the process , use bellow one

~~~bash 
if sudo lsof -t -i:4200; then sudo kill -9 $(sudo lsof -t -i:4200); fi
~~~~

Above command will check that process is running than kill by process id.
EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'

### Kill any process by it's process name
her I am killing htop process using bellow command.
~~~bash
sudo pkill htop 
~~~~

### sh: 1: cross-env: Permission denied npm ERR! code ELIFECYCLE

~~~bash
sudo chown -R $USER /usr/local

chmod -R a+x node_modules

~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
