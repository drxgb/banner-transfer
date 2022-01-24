<?php

namespace App\Service;

use App\Repository\TransfererRepository;
use App\Transferer;
use App\Util\Directory;
use App\Util\ImageFactory;
use Exception;

class TransfererService
{
	/** @var Transferer $transferet */
	private $transferer;
	/** @var TransfererRepository $repository */
	private $repository;


	public function __construct(Transferer $transferer)
	{
		$this->transferer = $transferer;
		$this->repository = new TransfererRepository();
	}

	public function start() : void
	{
		if (is_null($this->transferer))
			throw new Exception('Serviço de Transferência de arquivos está vazio!');

		$this->transfer($this->transferer->__get('source'));
	}


	private function setBannerPosition(int $position, int $height) : int
	{
		return ($position / $height) * 100;
	}


	private function transfer(string $source) : void
	{
		$files = Directory::getFiles($source);
		foreach($files as $file)
		{
			$path = $source . DIRECTORY_SEPARATOR . $file;
			if (is_dir($path))
			{
				$this->transfer($path);
				continue;
			}

			list($id, $ext) = explode('.', $file);
			if ($ext === 'jpg')
			{
				echo "Recebendo: $path\n";
				$destination = $this->transferer->__get('destination') . DIRECTORY_SEPARATOR;
				
				$images['l'] = ImageFactory::createResizedImage($path, 1280);
				$images['m'] = ImageFactory::createResizedImage($path, 640);
	
				list(, $h) = getimagesize($path);
				$bannerPos = $this->setBannerPosition($this->repository->getSourcePosition($id), $h);
				$this->repository->setDestinationPosition($id, $bannerPos);
	
				foreach ($images as $i => $image)
				{
					$imgDir = Directory::makePath($destination . $i . DIRECTORY_SEPARATOR . floor($id / 1000) . DIRECTORY_SEPARATOR);
					$imgPath = $imgDir . $file;
					imagejpeg($image, $imgPath);
					
					imagedestroy($image);
					unset($image);
	
					echo "Transferido: $imgPath\n";
				}
			}
			
		}
	}
}