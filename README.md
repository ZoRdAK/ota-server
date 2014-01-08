ota-server
==========

Deploy and install over the air your iOS &amp; Android apps like a breeze. Works everywhere on PHP server.

project security
================

Add this to your .htaccess (edit the path for .htpasswd)

```
AuthName "Secured Area"
AuthType Basic
AuthUserFile "/full/path/to/.htpasswd"
Require valid-user
```

Use .htpasswd to secure your OTA Server.

One account for all projects example :

```
global-user:$apr1$V4y4mlgu$D688WrBqz8P.RD9gweVSU.
```

One account for all projects and one account only to project "my-project" :

```
global-user:$apr1$V4y4mlgu$D688WrBqz8P.RD9gweVSU.

#my-project
user2:$apr1$cm9ym5tz$x94/IGrEdKHiRQqUifU7n.
```
Complex projects

```
global-user:$apr1$V4y4mlgu$D688WrBqz8P.RD9gweVSU.

#my-project
user2:$apr1$cm9ym5tz$x94/IGrEdKHiRQqUifU7n.

#cool-project
user2:$apr1$cm9ym5tz$x94/IGrEdKHiRQqUifU7n.
user3:$apr1$J8tR2T63$6iN7R5lai/Rbx5jQnqPi9/
```

Apache conf
================

`mod_rewrite` must be enabled on Apache.

For instance, on Debian you should do:

```
a2enmod rewrite
service apache2 restart
```


Virtual Host configuration example
================

Basic example of a virtual host Apache conf for ota-server.

```
<VirtualHost *:80>
	ServerName toto.net

	DocumentRoot /home/toto/ota-server/src
	<Directory /home/toto/ota-server/src/>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride None
		Order allow,deny
		allow from all
	</Directory>

	ErrorLog /home/toto/logs/error.log
	CustomLog /home/toto/logs/access.log common

	LogLevel warn

</VirtualHost>
```

PHP configuration
================

ota-server allows user to upload/download ipa files. As ipa files can be big, you should certainly increase your PHP's file upload limit in your php.ini.

For instance, php.ini is typically located at /etc/php5/apache2/php.ini

Edit this file and add:

```
file_uploads = On
upload_max_filesize = 20M //needs to be in {x}M format
post_max_size = 20M 
```

upload from curl
================

[OS] : ios or android

[PATH] : Path where you want to put your ipa (if path didn't exist, the server will create it for you)
```
curl -i -F name=upload -F filedata=@app.ipa http://[your-ota-server]/apps/[OS]/[PATH]
```

upload with UI
==============

http://[your-ota-server]/upload

delete with UI
==============

http://[your-ota-server]/delete

links
=====

Generate .htpasswd accounts [www.htaccesstools.com](http://www.htaccesstools.com/htpasswd-generator/)

© 2013
