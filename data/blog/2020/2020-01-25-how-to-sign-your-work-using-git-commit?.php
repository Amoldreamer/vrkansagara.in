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
$entry->setCreated(new DateTime('2020:01:25 23:59:00'));
$entry->setUpdated(new DateTime('2020:01:25 23:59:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['git', 'ssh', 'gpg']);

$body = <<<'EOT'
How to validate your git work using , git signed commit.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
~~~bash 
# Generate a new pgp key: (better to use gpg2 instead of gpg in all below commands)
gpg --gen-key
# maybe you need some random work in your OS to generate a key. so run this command: `find ./* /home/username -type d | xargs grep some_random_string > /dev/null`

# check current keys:
gpg --list-secret-keys --keyid-format LONG

# See your gpg public key:
gpg --armor --export YOUR_KEY_ID
# YOUR_KEY_ID is the hash in front of `sec` in previous command. (for example sec 4096R/234FAA343232333 => key id is: 234FAA343232333)

# Set a gpg key for git:
git config --global user.signingkey your_key_id

# To sign a single commit:
git commit -S -a -m "Test a signed commit"

# Auto-sign all commits globaly
git config --global commit.gpgsign true

~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
