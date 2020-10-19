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
$entry->setTitle('SSL Certificate in detail');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2017:12:22 23:27:27'));
$entry->setUpdated(new DateTime('2017:12:22 23:27:27'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['SSL', 'OpenSSL']);

$body = <<<'EOT'
What is SSL (Secure Socket Layer) ?
SSL is also known as `Transport Layer Security`.
### PEM Format
The PEM format is the most common format that Certificate Authorities issue certificates in. PEM certificates 
usually have extentions such as `.pem, .crt, .cer, and .key`. They are Base64 encoded ASCII files and 
contain `"-----BEGIN CERTIFICATE-----"` and `"-----END CERTIFICATE-----"` statements. Server certificates, 
intermediate certificates, and private keys can all be put into the PEM format.

### PKCS#7/P7B Format
The PKCS#7 or P7B format is usually stored in Base64 ASCII format and has a file extention of `.p7b` or `.p7c`. 
P7B certificates contain `"-----BEGIN PKCS7-----"` and `"-----END PKCS7-----"` statements. A P7B file only contains 
`certificates and chain certificates`, not the `private key`. Several platforms support P7B files 
including `Microsoft Windows and Java Tomcat`.

EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
![alt text](/assets/images/blog/ssl-setup-diagram.png "SSL Certificate in detail")
### PKCS#12/PFX Format
The `PKCS#12` or `PFX` format is a binary format for storing the server certificate, any intermediate certificates,
 and the private key in one encryptable file. PFX files usually have extensions such as .pfx and .p12. PFX files 
 are typically used on Windows machines to import and export certificates and private keys.

When converting a PFX file to PEM format, OpenSSL will put all the certificates and the private key into a single file.
You will need to open the file in a text editor and copy each certificate and private key 
(including the BEGIN/END statments) to its own individual text file and save them as `certificate.cer`, 
`CACert.cer`, and `privateKey.key` respectively.

OpenSSL Commands to Convert SSL Certificates on Your Machine
It is highly recommended that you convert to and from .pfx files on your own machine using OpenSSL so you can
keep the private key there. Use the following OpenSSL commands to convert SSL certificate to different formats
on your own machine:

### OpenSSL Convert PEM
Convert PEM to P7B
~~~bash
openssl crl2pkcs7 -nocrl -certfile certificate.cer -out certificate.p7b -certfile CACert.cer
~~~
Convert PEM to PFX
~~~bash
 openssl pkcs12 -export -out certificate.pfx -inkey privateKey.key -in certificate.crt -certfile CACert.crt
~~~

###  OpenSSL Convert P7B
Convert P7B to PEM
~~~bash
openssl pkcs7 -print_certs -in certificate.p7b -out certificate.cer
~~~
### Convert P7B to PFX
~~~bash
openssl pkcs7 -print_certs -in certificate.p7b -out certificate.cer
openssl pkcs12 -export -in certificate.cer -inkey privateKey.key -out certificate.pfx -certfile CACert.cer
~~~

### OpenSSL Convert PFX
Convert PFX to PEM
~~~bash
openssl pkcs12 -in certificate.pfx -out certificate.cer -nodes
~~~
EOT;

$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
