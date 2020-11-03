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
$entry->setCreated(new DateTime('2017:12:23 23:27:27'));
$entry->setUpdated(new DateTime('2017:12:23 23:27:27'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['happy', 'work', 'life']);

$body = <<<'EOT'
I have read some where these following rules to become more happier with work life.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
1. Trust no one but respect everyone.
2. What happens in office, remain in office. Never take office gossips to home and vice versa.
3. Enter office on time, leave on time. Your desktop is not helping to improve your health.
4. Expect nothing. If somebody helps, feel thankful. If not, you will learn to know things on your own.
5. Never rush for a position. If you get promoted, congrats. If not, it doesn't matter. You will always be remembered for your knowledge and politeness, not for your designation.
6. Never run behind office stuff. You have better things to do in life.
7. Avoid taking everything on your ego. Your salary matters. You are being paid. Use your assets to get happiness.
8. It doesn't matter how people treat you. Be humble. You are not everyone's cup of tea.
9. In the end nothing matters except family, friends, home and inner peace.
EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
