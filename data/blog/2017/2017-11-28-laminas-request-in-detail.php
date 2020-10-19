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
$entry->setTitle('Laminas request in detail');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2017:08:17 23:27:27'));
$entry->setUpdated(new DateTime('2017:08:23 23:27:27'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['laminas', 'zend', 'framework','php']);

$body = <<<'EOT'
How to access route, post, get etc. parameters in Laminas Framework , Formally known as `Laminas framework`.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'


~~~php
$this->params()->fromPost('paramname');   // From POST

$this->params()->fromQuery('paramname');  // From GET

$this->params()->fromRoute('paramname');  // From RouteMatch

$this->params()->fromHeader('paramname'); // From header

$this->params()->fromFiles('paramname');  // From file being uploaded
~~~
EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
