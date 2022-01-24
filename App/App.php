<?php

namespace App;

use App\Exception\InvalidPathException;
use App\Service\TransfererService;

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
			$service = new TransfererService($transferer);
			
			$transferer->parseSource();
			$transferer->parseDestination();

			if (GUI::answerYesOrNo("\nIniciar transferência?"))
			{
				echo "\nIniciando a transferência dos banners...\n\n";
				$service->start();
				echo "\nBanners transferidos com sucesso! \\o/\n";
			}
		}
		catch (InvalidPathException $e)
		{
			echo 'ERRO: ' . $e->getMessage() . PHP_EOL;
			return 1;
		}

		echo "Encerrando o programa...\n";
		return 0;
	}


	private static function getTargetPath(string $label)
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