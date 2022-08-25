<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
$db = conectarDB();
$db->set_charset('utf8');


use App\ActiveRecord;

ActiveRecord::setDB($db);