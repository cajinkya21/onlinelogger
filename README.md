This file contains the documentation for the setup of online logger website on you personal system.
The steps for the configuration are as follows:-

1)open terminal. Type mysql -v. if 	message like 
"ERROR 1045 (28000): Access denied for user '<example>'@'localhost' (using password: NO)"
then you already have mysql and setup.
2)Otherwise, open terminal and type sudo apt-get install lamp-server^    and wait for the installation to complete.
3)At the end of the installation you'll be asked for the password that is the password for the mysql server. Type the password, and remember it for future references.
4)After complete installation, open terminal, and type mysql -u root -p -h localhost
5)Then type the password that you remembered. and then u'll be able to see the mysql prompt.
6)Then type type following commnds in the mysql> prompt
Create Database olLogdb;
use olLogdb;
Create user 'olLoguser'@'localhost' identified by olLogpass;
grant all privileges on olLogdb.* to 'olLoguser'@'localhost';
they type quit;

then The setup is completed.



7)Now download phpmyadmin from internet and extract the setup in /var/www/html directory.

8)Then open firefox.
9)type localhost/PhpMyAdmin
10)type the ID as olLoguser and the password is olLogpass
11)Then click on the database (olLogdb) in left panal.
12)Then click the import button and browse the myDataConfig.sql.zip file attached by me.
13)and then go to browser again and type localhost/onlineLog
14)And done deal!
