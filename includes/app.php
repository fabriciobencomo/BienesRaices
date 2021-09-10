<?php
require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//Connecting Database
$db = connectDB();

use Model\ActiveRecord;

ActiveRecord::setDB($db);

