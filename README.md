# Symfony5 eCommerce Project

> eCommerce platform built with Symfony5 for learning purposes.

[See Website Here](https://fonyshop.herokuapp.com/)
[![screenshot](https://github.com/bleriotnoguia/symfony5-ecommerce/blob/main/public/assets/img/website.png)](https://theproshop.herokuapp.com/)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

## Features

- Full featured shopping cart
- Product reviews and ratings
- Top products carousel
- User profile with orders
- Admin product management
- Admin user management
- Admin Order details page
- Mark orders as delivered option
- Checkout process (shipping, payment method, etc)
- Stripe / credit card integration

## Usage

### Env Variables

Create a .env file in then root and add the following

```
APP_ENV=dev
APP_SECRET=xxxxxxxxxxxxxxxxxxxxxx
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/fonyshop?serverVersion=5.7"
```

### Mailjet api key

Update the $api_key and $api_key_secret variable sto match your mailjet API Key

```
/src/Classe/Mail.php
```

### Install Dependencies (backend)

```
composer install
symfony console doctrine:migrations:migrate
```

### Run

Run the command below then open http://localhost:8000/

```
symfony serve
```

## Author

- **Bleriot Noguia**
- [Mikael Houdoux Course](https://www.udemy.com/course/apprendre-symfony-par-la-creation-dun-site-ecommerce/)
