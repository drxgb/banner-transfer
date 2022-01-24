<?php

namespace App;

use App\Exception\InvalidPathException;

abstract class App
{
	public static function start()
	{
		echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
		echo "\tBANNER TRANSFER" . PHP_EOL;
		echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

		try
		{
			$rootDir = self::getTargetPath('Diretório raiz');
			$transferer = new Transferer(
				$rootDir . '/profile_covers',
				$rootDir . '/profile_banners'
			);
			
			$transferer->parseSource();
			$transferer->parseDestination();
			$transferer->start();
		}
		catch (InvalidPathException $e)
		{
			echo 'ERRO: ' . $e->getMessage() . PHP_EOL;
			return 1;
		}
		return 0;
	}


	private static function getTargetPath(string $label) : string | InvalidPathException
	{
		
		$ok = false;
		while (!$ok)
		{
			if ($label)
				echo $label . ': ';
			$input = trim(fgets(STDIN));
			$ok = GUI::answerYesOrNo("Diretório: $input\nEstá correto?");
		}

		if (!is_dir($input))
			throw new InvalidPathException("$input não é um diretório!\n");

		return $input;
	}
}