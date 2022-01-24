<?php

namespace App\Util;

use GdImage;

abstract class ImageFactory
{
	public static function createResizedImage(string $file, int $width) : GdImage | null
	{
		list($sw, $sh) = getimagesize($file);
		$dw = $width;
		$dh = $sh * ($width / $sw);

		$destination = imagecreatetruecolor($dw, $dh);
		$source = imagecreatefromstring(file_get_contents($file));

		if (imagecopyresized($destination, $source, 0, 0, 0, 0, $dw, $dh, $sw, $sh))
			return $destination;
		return null;
	}
}