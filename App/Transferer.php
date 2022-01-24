<?php

namespace App;

use Directory;

class Transferer
{
	public function __construct(
		private string $source,
		private string $destination
	)
	{
		$this->source = realpath($source);
		$this->destination = realpath($destination);
	}


	public function start() : void
	{

	}


	public function parseSource() : void
	{
		echo "\nDiretório Fonte: " . $this->source . PHP_EOL;
		echo "Arquivos encontrados: " . $this->countFiles($this->source) . PHP_EOL;
	}


	public function parseDestination() : void
	{
		echo "\nDiretório Destino: " . $this->destination . PHP_EOL;
		echo "Arquivos encontrados: " . $this->countFiles($this->destination) . PHP_EOL;
	}


	private function countFiles(string $dir) : int
	{
		$count = 0;
		$files = array_filter(scandir($dir), function($file) {
			return $file !== '.' && $file !== '..';
		});

		foreach ($files as $file)
		{
			$path = $dir . '/' . $file;
			$count += is_dir($path) ? $this->countFiles($path) : 1;
		}

		return $count;
	}
}