# Laravel REST API for User, Product, and Order Management

In this project, I've implemented the `Repository pattern` and utilized Laravel's default caching system for the product listing. The caching mechanism is revalidated using `Laravel Observer model events`. Running the `db:seed`command will create an admin user with the login ID "admin@gmail.com" and the password "password," along with generating a set of products.

## Requirements
- PHP 8.1
- Composer
- MySQL 

## Setup Instructions
- Clone the Repository from github.
- run this command `composer install`.
- rename .env.example to .env and connect database to mysql.
- run  command `php artisan key:generate` ,`php artisan jwt:secret` ,`php artisan migrate` and `php artisan db:seed`



# API Documentation 


| SL | Title/Description     | Url                        |  Method                   |Authentication     |    Status code | 
| :-------- | :------- |  :------------------------- |  :-------------------------|:-------------------------| :-------------------------| 
| `1` | `For registration  user/client` | /api/v1/register    | *POST* |              **false**       |              200 |
| `2` | `For Login  user/Admin`         | /api/v1/login    | *POST* |              **false**       |              200 |
| `3` | `For Loge out   user/Admin`     | /api/v1/logout    | *POST* |              **true**       |              200 |
| `4` | `For Token Refresh`     | /api/v1/refresh-token    | *POST* |              **false**       |              200 |
| `5` | `Get Production List`     | /api/v1/products   | *GET* |              **false**       |              200 |
| `6` | `Store Product`     | /api/v1/products   | *POST* |              **true(Admin)**       |              200 |
| `7` | `Update Product`     | /api/v1/products/{id}   | *POST* |              **true(Admin)**       |              200 |
| `8` | `New Order`     | /api/v1/orders/   | *POST* |              **true(user)**       |              200 |
| `9` | `Order List`     | /api/v1/orders/   | *GET* |              **true(user)**       |              200 |
| `10` | `Order Details`     | /api/v1/orders/{id}   | *GET* |              **true(user)**       |              200 |