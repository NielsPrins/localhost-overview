<p align="center">
  <img  src="https://user-images.githubusercontent.com/28888849/72172628-ea4a2600-33d5-11ea-9f2e-bbdf5137676e.jpg" height="50">
</p>
<div align="center">A quick overview of all your locally hosted projects.</div>

# Usage
Go to localhost to view all your projects.  
Clicking on a project will open the projects page.  
This is done with the help of [localtest.me](https://readme.localtest.me/ "readme.localtest.me").  
The URL of your project will be the name of the folder .localtest.me  
This is way easier when you are starting a new project, there are no knew configs needed!

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
# Screenshots

![Localhost overview](https://user-images.githubusercontent.com/28888849/72179795-fccc5b80-33e5-11ea-805c-7a0815c741be.png "Localhost overview")
