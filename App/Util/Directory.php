<?php

namespace App\Util;

abstract class Directory
{
	public static function getFiles(string $path)
	{
		if (is_dir($path))
		{
			return array_filter(scandir($path), function ($file) {
				return $file !== '.' && $file !== '..';
			});
		}
		return null;
	}


	public static function makePath(string $path) : string
	{
		if (!is_dir($path) && !is_file($path))
			mkdir($path, 0777, true);
		return $path;
	}
}