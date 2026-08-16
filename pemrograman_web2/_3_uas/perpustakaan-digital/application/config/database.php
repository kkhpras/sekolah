<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Database Configuration - Perpustakaan Digital
|--------------------------------------------------------------------------
|
| Ganti pengaturan berikut sesuai dengan konfigurasi MySQL Anda:
| - hostname : alamat server MySQL (biasanya 'localhost')
| - username : username MySQL Anda
| - password : password MySQL Anda
| - database : nama database (perpustakaan_db)
| 
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'perpustakaan',        // Ganti sesuai username MySQL Anda
    'password' => 'perpustakaan123',            // Ganti sesuai password MySQL Anda
    'database' => 'perpustakaan_db', // Nama database
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
