# Data Single
This is a Dating website for programmers. The website has old 90's look to it with simple and clean user interface.

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

## Prerequisites
To run the website on your local machine you would need two things:
* A local HTTP WEB Server
* Database Management System (DBMS)

## Installing
There are many softwares available you can use to start localhost. I recomend Apache Web Server and PostgreSQL just because they are open-source and available on all platforms (Linux, Mac , Windows)

Follow the link below for Instructions on how to Install Apache Web Server on you computer
* https://www.sitepoint.com/how-to-install-apache-on-windows/

Link below to install PostreSQL
* https://www.labkey.org/Documentation/wiki-page.view?name=installPostgreSQLWindows

Once you have installed both software clone this repository in your computer and follow the steps below to set up software:
1) Go to folder where you downloaded Apache web server. Open "conf" folder.
2) open file "httpd.conf" go to line line 244 to 246 set directory to folder to the folder where you cloned this repository like this
![image](https://user-images.githubusercontent.com/27502011/35115759-44ac4b86-fc57-11e7-8db7-e0ed3523d0f5.png)
now your http web server should be all set up Moving on to PostgreSQL

1) after installing PostgreSQL, search up software "pgAdmin <version#>" in your computer.
2) set up database by creating new Database.
3) copy all .sql files form Sql Directory from this repository and execute them in your database. This will create all the tables necessary for database.

this shold set up your database connection now go to repository and open up file "constants.php" and add your database name, user name and password. replace with values on right 
![image](https://user-images.githubusercontent.com/27502011/35116235-b4825062-fc58-11e7-924b-306a1fab39f0.png)

Now you should be all set up to use the website.

## Built With
* PostgreSQL - Database Management System
* Apache Web Server - Local Server

## Authors
This repository was moved from Durham Colleg's Git to Github.com. Its previous authors included <br/>
- Nathan Williams - Profile View and Generating Fake users<br/>
- Qasim Iqbal (me) - Profile Search Functionality<br/>
- Jonathan Hermans - User Login / Logout <br/>
- Karence Ma - Setting up Database and SQL scripts<br/>
The functionality shown foreach user is not limited to what is shown above. It is overall generally what each author worked on.

