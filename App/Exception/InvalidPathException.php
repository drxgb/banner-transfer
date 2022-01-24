<?php

namespace App\Exception;

use Exception;

class InvalidPathException extends Exception
{
	public function __construct(string $msg)
	{
		parent::__construct($msg);
	}
}