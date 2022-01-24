<?php

namespace App;

use App\Util\Directory;

class Transferer
{
	public function __construct(
		private string $source,
		private string $destination
	)
	{
		$this->source = realpath(Directory::makePath($source));
		$this->destination = realpath(Directory::makePath($destination));
	}

	public function __get($attr)
	{
		return $this->$attr;
	}


	public function parseSource() : void
	{
		echo "\nDiretório Fonte: " . $this->source;
		echo "\nArquivos encontrados: " . $this->countFiles($this->source) . PHP_EOL;
	}


	public function parseDestination() : void
	{
		echo "\nDiretório Destino: " . $this->destination;
		echo "\nArquivos encontrados: " . $this->countFiles($this->destination) . PHP_EOL;
	}


	private function countFiles(string $dir) : int
	{
		$count = 0;
		$files = Directory::getFiles($dir);

		foreach ($files as $file)
		{
			$path = $dir . '/' . $file;
			$count += is_dir($path) ? $this->countFiles($path) : 1;
		}

		return $count;
	}
}