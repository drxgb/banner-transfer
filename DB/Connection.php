<?php

namespace DB;

use PDO;

abstract class Connection
{
	private static $db;
	private static $config;

	public static function connect(
		array $config,
		bool $persistent = false
	) : void
	{
		self::$db = new PDO(
			'mysql:host=' . $config['host'] . ';dbport=' . $config['port'] .';dbname=' . $config['schema'],
			$config['user'],
			$config['password'],
			[
				PDO::ATTR_PERSISTENT => $persistent,
			]
		);

		self::$config = $config;
	}


	public static function get() : PDO
	{
		return self::$db;
	}

	public static function getConfiguration(string $key)
	{
		if (!array_key_exists($key, self::$config))
			return null;
		return self::$config[$key];
	}
}