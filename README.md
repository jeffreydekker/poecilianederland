# Fish Registration Application

This is an invite-only fish registration database built in Laravel. This application allows registered users to manage and update their fish inventory in a secure and user-friendly environment.

## Features

- **User Registration & Authentication**: Only invited users can register, ensuring a private and secure environment.
- **Fish Inventory Management**: Users can add, update, and delete fish entries in their inventory.
- **Detailed Fish Profiles**: Each fish entry includes details like species, location of catch and more.
- **Dashboard Overview**: A quick view of all registered fish and key inventory insights.
- **Responsive Design**: Not yet optimized for mobile

## Installation

git clone https://github.com/jeffreydekker/poecilianederland.git
cd poecilianederland

Install dependencies:
composer install
npm install
npm run dev

Environment Configuration:
Copy .env.example to .env.
Update database credentials in the .env file.

Database Setup:
php artisan migrate

Start the Application:
php artisan serve

Usage
User Registration: Admins can invite users, who will then receive an email with a registration link. Set up a mailing test enviroment in something like Mailtrap. 
-Temporarily disable the middleware for the /beheerder route.
-Make an account for yourself on /beheerder
-Log in with the generated password sent to mailtrap or other service
-Change your password in the user settings
-Make yourself an admin by going into the database and set your user colomn "isAdmin" to 1
-Enable the middleware of /beheerder route again to secure the admin page
-You can now use the whole application

Technologies Used:
Laravel backend framework
MySQL database
JavaScript for frontend interactions
CSS + Bootstrap

Contributing:
I'm not accepting any pull requests as the project is finished.

License
This project is open-source and available under the MIT License.
