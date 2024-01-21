<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\MySqlConnection;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command("setup", function(){
    $this->info('Running create main database...');

    $database = config("database.connections.main.database");
    $host = config("database.connections.main.host");
    $port = config("database.connections.main.port");
    $user = config("database.connections.main.username");
    $password = config("database.connections.main.password");

    $pdo = new PDO("mysql:host=$host:$port", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buat database jika belum ada
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
    $pdo = null;

    $this->info('Running migrations...');
    Artisan::call('migrate --seed');

    $this->info('Generate key...');
    Artisan::call('key:generate');

    $this->info('Application already serve, run php artisan serve');
})->purpose("Setup application");
