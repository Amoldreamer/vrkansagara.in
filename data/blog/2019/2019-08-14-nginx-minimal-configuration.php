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
$entry->setCreated(new DateTime('2019:08:14 16:33:48'));
$entry->setUpdated(new DateTime('2019:08:14 16:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['linux','server','nginx']);

$body = <<<'EOT'
### Basic nginx configuration for with `php-fpm` as reverse proxy

EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'

~~~nginx

# redirect all http traffic to https
server {
    # Listen port 80 at ipv4 and ipv6
    listen 80;
    listen [::]:80;
    
    # server name would be your server FQDN or dns host name or ip address seperated by space
    server_name example.com;

    return 301 https://$host$request_uri;
}

server {

    # Listen port 443 at ipv4 and ipv6
    listen 443 ssl;
    listen [::]:443 ssl;

    # server name would be your server FQDN or dns host name or ip address seperated by space
    server_name example.com;

    root /var/www/html;

	add_header X-Frame-Options "SAMEORIGIN";
	add_header X-XSS-Protection "1; mode=block";
	add_header X-Content-Type-Options "nosniff";


    # Logs
    access_log /var/log/nginx/example-com-access.log;
    error_log /var/log/nginx/example-com-error.log;

    index index.php index.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        # Fast cgi run's on ip + port combination
        fastcgi_pass 127.0.1.1:9072;
	    fastcgi_read_timeout 300;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
    }
}

~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
