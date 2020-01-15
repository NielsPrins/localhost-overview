<p align="center">
  <img  src="https://user-images.githubusercontent.com/28888849/72172628-ea4a2600-33d5-11ea-9f2e-bbdf5137676e.jpg" height="50">
</p>
<div align="center">A quick overview of all your locally hosted projects.</div>

# Usage
Go to localhost to view all your projects.  
Clicking on a project will open the projects page.  
This is done with the help of [localtest.me](https://readme.localtest.me/ "readme.localtest.me").  
The URL of your project will be: [name_of_folder].localtest.me  
This way you can begin programming immediately when starting a new project, no configs needed!

# Installation
#### XAMPP
Enable "mod_vhost_alias" by uncommenting the following line in "C:\xampp\apache\conf\httpd.conf" (Removing the hashtag)
```
LoadModule vhost_alias_module modules/mod_vhost_alias.so
```

Enable the new URL's by replacing the content of "C:\xampp\apache\conf\extra\httpd-vhosts.conf" with:
```
<VirtualHost *:80>
	ServerName localhost
	DocumentRoot "C:/xampp/htdocs/localhost-overview"
</VirtualHost>

<VirtualHost *:80>
	ServerAlias *.localtest.me
	VirtualDocumentRoot "C:/xampp/htdocs/%-3+/"
</VirtualHost>
```

Then navigate to your XAMPP folder ("C:\xampp\htdocs") and clone this repo:
```
git clone https://github.com/NielsPrins/localhost-overview.git
```
Your all done!  
Start new project by adding a folder in "C:\xampp\htdocs" or copy old projects over.

#### WampServer

Enable the new URL's by replacing the content of "C:\wamp64\bin\apache\apache[version]\conf\extra\httpd-vhosts.conf" (Replace "[version]") with:
```
<VirtualHost *:80>
	ServerName localhost
	DocumentRoot "${INSTALL_DIR}/www/localhost-overview"
</VirtualHost>

<VirtualHost *:80>
	ServerAlias *.localtest.me
	VirtualDocumentRoot "${INSTALL_DIR}/www/%-3+/"
</VirtualHost>
```

Then navigate to your WampServer folder ("C:\wamp64\www") and clone this repo:
```
git clone https://github.com/NielsPrins/localhost-overview.git
```
Your all done!  
Start new project by adding a folder in "C:\wamp64\www" or copy old projects over.

#### Linux (ubuntu)

Enable "mod_vhost_alias":
```
sudo a2enmod vhost_alias
```

Enable the new URL's by replacing the content of "/etc/apache2/sites-available/000-default.conf" with:
```
<VirtualHost *:80>
	ServerName localhost
	DocumentRoot "/var/www/localhost-overview"
</VirtualHost>

<VirtualHost *:80>
	ServerAlias *.localtest.me
	VirtualDocumentRoot "/var/www/%-3+/"
</VirtualHost>
```

Make sure you have "php-curl" installed:
```
sudo apt-get install php-curl -y
```

Then navigate to the web folder folder ("/var/www/") and clone this repo
```
git clone https://github.com/NielsPrins/localhost-overview.git
```

Make sure apache can access the folder
```
sudo chown -R www-data:www-data /var/www/localhost-overview/
```

Restart apache with all the changes we've just made 
```
sudo systemctl restart apache2
```
Your all done!  
Start new project by adding a folder in "C:\wamp64\www" or copy old projects over.


# Screenshots

![Localhost overview](https://user-images.githubusercontent.com/28888849/72179795-fccc5b80-33e5-11ea-805c-7a0815c741be.png "Localhost overview")
