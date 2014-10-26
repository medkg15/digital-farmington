<?php

require_once('../vendor/autoload.php');
require_once('../password.php');
DB::$host = 'ec2-54-68-234-52.us-west-2.compute.amazonaws.com';
DB::$user = 'farmington';
DB::$password = db_password;
DB::$dbName = 'farmington';