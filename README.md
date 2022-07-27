# SnapFood

a clone of snapfood with its many features.
usage **Laravel** & **tailwindcss** for this project.
#  Description
In this project, the admin and restaurateur section is SSG and the customer section is SSG & API.
The packages used for backend of this project are:

 - Jeststream
 - Sanctum
 - Livewire
 - laravel-charts
 - laravel-map
 
 #  Prerequisites
  - PHP > 8.1
  - Laravel 9
  
 # Instalation
    composer update
    npm install && npm run dev
    create `snapfood` table in database
    php artisan migrate --seed
    php artisan queue:work
    php artisan serve

## features

**admin**


 - CRUD Food Category
 - CRUD Food Party (with job & queue)
 - confirm restaurants & food
 - delete requested comments

**restaurant**

 - edit restaurant details(title, category, phone, delivery fee, schedule, address on map)
 - CRUD food
 - see orders and change status (send mail to customer for change, track delay delivery) 
 - see reports (table & chart)
 - see comments & set answer

**Customer**

 - CRUD order
 - see restaurant
 - CRUD personal info
 - CR comments

![alt text](/photos/home.png)
![alt text](/photos/restaurantsShow.png)
![alt text](/photos/commentsOnFood.png)
![alt text](/photos/restaurant.png)
![alt text](/photos/adminDashboard.png)
![alt text](/photos/restaurantDetiles.png)
![alt text](/photos/comments.png)
![alt text](/photos/foodCRUD.png)
![alt text](/photos/order.png)
