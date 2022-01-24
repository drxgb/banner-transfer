<?php

namespace DB;

use PDO;
use PDOException;

abstract class Connection
{
	private static $db;

	public static function connect(
		string $host,
		string | int $port,
		string $schema,
		string $user,
		string $pass,
		bool $persistent = false
	) : void
	{
		self::$db = new PDO(
			"mysql:host=$host;dbport=$port;dbname=$schema",
			$user,
			$pass,
			[
				PDO::ATTR_PERSISTENT => $persistent,
			]
		);
	}


	public static function get() : PDO
	{
		return self::$db;
	}
}