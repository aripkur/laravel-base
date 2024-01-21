# BASE PROJECT LARAVEL

Base project laravel spesifikasi

- Laravel version 8 [(laravel-v8)](https://laravel.com/docs/8.x)
- AdminLte html template [(adminLte)](https://adminlte.io/)
- Captcha 

## Setup
Instal laravel dan dependency lainnya

    composer install

Copy .env.example ke .env

konfigurasi

    #DB_MAIN menggunakan mysql

    DB_MAIN_HOST=127.0.0.1
    DB_MAIN_PORT=3306
    DB_MAIN_DATABASE=laravel_base
    DB_MAIN_USERNAME=root
    DB_MAIN_PASSWORD=
Run

    php artisan setup

  
  akan membuat database sesuai `DB_MAIN` di `.env` dan migrate table user beserta seednya

Run
  
    php artisan serve

Buat catatan saja, dari pada dihapus :)
