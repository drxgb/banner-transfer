<?php

ini_set('memory_limit','1024M');

include_once('includes/include.php');
include_once('config.php');
use App\App;
use DB\Connection;


Connection::connect($config, true);
App::start();