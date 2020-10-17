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

$entry->setId(pathinfo(__FILE__,PATHINFO_FILENAME));
$entry->setTitle('Expected response code 250 but got code “535”, with message "535-5.7.8 Username and Password not accepted');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2020:06:20 01:44:08'));
$entry->setUpdated(new DateTime('2020:06:20 01:44:08'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['google', 'smtp']);

$body = <<<'EOT'
I researched on the internet and some answers includes enabling the "access for lesser app" and "unlocking gmail captcha" which sadly didn't work for me until I found the 2-step verification.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
What I did the following was:

enable the 2-step verification to google [!HERE](https://www.google.com/landing/2step/)

Create App Password to be use by your system [!HERE](https://security.google.com/settings/security/apppasswords)

I selected Others (custom name) and clicked generate

Went to my env file in laravel and edited this

MAIL_USERNAME=talentscoutphil@gmail.com

MAIL_PASSWORD=thepasswordgenerated

Restarted my apache server and boom! It works again. This was my solution. I created this to atleast make other people not go wasting their time researching for a possible answer.
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
