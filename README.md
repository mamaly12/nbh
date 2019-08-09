# NBH

STORIES
============
• Create 2 Web Application (BackOffice + Client Portal) based on PHP Laravel
Web framework.

• Each county has a different tax rate and collects a different amount of taxes.

TODO
============
The software should have the following features:
 
 Client Applications:
 
   • Client Portal Application. This is a simple application where the client can
  make login/register and go inside on the dashboard. That App should have just
  3 routes:
  
    1. '/login', client make login (in case of success, redirect to dashboard).
    
    2. '/register' client make register (in case of success, redirect to dashboard).
      (a) Information required for register form is 'name', 'surname', 'date-of-
    birth', 'email', 'password', 'phone-number'.
    
      (b) If client made successful register, all fields with random data 'ad-
      dress', 'country', 'trading-account-number', 'balance', 'open-trades','close-trades'.
      
    3. '/dashboard', this is a client dashboard, where client can see all infor-mation about him ('name', 'surname', 'date-of-birth', 'email', 'phone- number', 'address', 'country', 'trading-account-number', 'balance', 'open-trades', 'close-trades').

BackOffice Applications:

• This is an application for back-oce stu to check the client's account. The diference between 'client' and 'user' is, user are for backOffice to check clients
data.

  1. '/login', the user make login (in case of success, redirect to dashboard)
  
  2. '/dashboard', user can see the table of all clients.
  
  3. '/client/id', the user can see all the details about the client and also can edit information.
  
  4. '/create-user', this URL will create new user in back-office application,felds for creating (`email`, `password`, `role`).
  
DB Tabels/Schema

  Users id (autoincrement), email, password(md5), role-id
  
  Roles id (autoincrement), name
  
  Clients id (autoincrement), name, surname, date-of-birth, email, password(md5)
phone-number, address, country, trading-account-number, balance, open-trades, close-trades


BackOffice Roles
  1. `Administrator`, can view/edit everything (all clients) and create a new user for back office.
  2. `User`, can view/edit everything (all clients).
 
REQUIREMENTS
============
• Symfony 4.3. (https://symfony.com/download)

• Apache WEB server, version 2.0 or higher. ( http://httpd.apache.org/download.cgi )

• PHP 7.3. ( http://www.php.net/ )

• MySQL 8. ( http://dev.mysql.com/downloads/ )

• IDE (like PhpStorm). (https://www.jetbrains.com/phpstorm/download/)

INSTALLATION
============
1- Download and Extract the Source Code.

2- Create DataBase:

   - in the terminal of the IDE type the following commands:

		a. composer update
		
		b. according to env file of the root of the project DATABASE_URL=mysql://mohammad:mohammad@127.0.0.1:3306/usersmanegement
		
		create a user with password which has access to the database: DATABASE_URL=mysql://user_db:user_password@127.0.0.1:3306/dbName
		
		c. php bin/console doctrin:database:create

3- Create Table:

    -in the terminal of the IDE type these commands to create tables for the entities of the project:
    
    a. php bin/console doctrine:migrations:diff

    b. php bin/console doctrine:migrations:migrate
        
