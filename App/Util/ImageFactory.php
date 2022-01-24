<?php

namespace App\Util;

use GdImage;

abstract class ImageFactory
{
	public static function createResizedImage(string $file, int $width)
	{
		list($sw, $sh) = getimagesize($file);
		$dw = $width;
		$dh = $sh * ($width / $sw);

		$destination = imagecreatetruecolor($dw, $dh);
		$source = imagecreatefromstring(file_get_contents($file));

		imagecopyresized($destination, $source, 0, 0, 0, 0, $dw, $dh, $sw, $sh);
		imagedestroy($source);
		unset($source);
		return $destination;
	}
}