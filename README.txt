================================================================================
Istall Atom:
https://atom.io/download/windows_x64




================================================================================
Install WAMP Server (32bit):
https://sourceforge.net/projects/wampserver/files/WampServer%203/WampServer%203.0.0/wampserver3.2.6_x86.exe/download

================================================================================
Edit file: C:\wamp\bin\apache\apache2.4.51\conf\extra
...by adding the following lines:

#
<VirtualHost *:80>
	ServerName theweb
	DocumentRoot "c:/wamp/www/theweb"
	<Directory  "c:/wamp/www/theweb/">
		Options +Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Require local
	</Directory>
</VirtualHost>


================================================================================
Visit GitHub page:
https://github.com/ARTidas/theweb


================================================================================
Download and install MySQL WorkBench:
https://dev.mysql.com/get/Downloads/MySQLGUITools/mysql-workbench-community-8.0.30-winx64.msi
