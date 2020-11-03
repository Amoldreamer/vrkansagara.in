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
$entry->setCreated(new DateTime('2019:09:10 16:33:48'));
$entry->setUpdated(new DateTime('2020:11:29 07:18:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['linux','git']);

$body = <<<'EOT'
* Store all your cred into system helper 

~~~bash
git config --global credential.helper store
# Set the cache to timeout after 1 hour (setting is in seconds)
git config --global credential.helper 'cache --timeout=3600'
~~~
EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'
* Ignore file mode change in current working tree

~~~bash
# For individual project
git config core.fileMode false 
# For system wide all git project
git config --global core.fileMode false
~~~

* Reset current branch to previous stat

~~~bash
git reset --hard HEAD
~~~

* How to save your work into git clipboard

~~~bash
git stash
~~~

* Easy way to update your current code using same branch.

~~~bash
git pull --rebase
~~~

#### Final my `.gitconfig` file looks like

~~~bash
cat ~/.gitconfig
~~~

~~~bash 
[user]
    email = vrkansagara@gmail.com
    name = Vallabh Kansagara
[credential]
    helper = store
[core]
    fileMode = false
~~~

EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
