Poecilia Nederland

An invite-only registration application.

Dependencies: <br>
PHP => 8.2 <br>
Composer <br>
npm <br>
www.mailtrap.io

To get started run:
```
php artisan serve
npm run dev
```
In web.php turn off the MustBeAdmin middleware for the /beheerder and /register routes to be able to create a new account. <br>
Connect the application to your database of choice. Edit the .env to look like this for MySQL with your own credentials: <br>
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mydatabase
DB_USERNAME=root
DB_PASSWORD=mysecretpassword

```

The database is now linked and the .env is set up. Run the following command to migrate all the tables to your database:
```
php artisan migrate
```

To create a user, head over to localhost/beheerder. Then enter your credentials. In mailtrap.io we will see we've got an email with a temporary password which we will have to change in the user settings to verify our user. <br>
To assign moderator privileges, go into your users table and set the column 'isAdmin" of your user to 1. <br>
Now in web.php for the /beheerder and /register routes the middleware 'MustBeAmdin' have to be included again. <br>
<br>
You are now an admin! Enjoy the application <3 <br>
<br>
To import a csv, put your data.csv in the public folder and uncomment the route for /import-csv and then visit that url in the browser.





