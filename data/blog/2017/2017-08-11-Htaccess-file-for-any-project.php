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
$entry->setCreated(new DateTime('2017:08:17 23:27:27'));
$entry->setUpdated(new DateTime('2017:08:23 23:27:27'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['.htaccess', 'wordpress', 'apache']);

$body = <<<'EOT'
Quick , Easy and Fast `.htaccess` for any kind of project.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
~~~apache
RewriteEngine On
# The following rule tells Apache that if the requested filename
# exists, simply serve it.
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
# The following rewrites all other queries to index.php. The
# condition ensures that if you are using Apache aliases to do
# mass virtual hosting, the base path will be prepended to
# allow proper resolution of the index.php file; it will work
# in non-aliased environments as well, providing a safe, one-size
# fits all solution.
RewriteCond %{REQUEST_URI}::$1 ^(/.+)(.+)::\2$
RewriteRule ^(.*) - [E=BASE:%1]
RewriteRule ^(.*)$ %{ENV:BASE}index.php [NC,L]
~~~

If you want to force http request to https then add following code after RewriteEngine on

### Htaccess file for WordPress project.
~~~apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
~~~

~~~apache
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
~~~

EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
