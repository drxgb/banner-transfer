<?php

include_once('includes/include.php');
include_once('config.php');
use App\App;
use DB\Connection;


Connection::connect(
	$config['host'], 
	$config['port'],
	$config['schema'],
	$config['user'],
	$config['password'],
	true
);
App::start();