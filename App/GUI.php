<?php

namespace App;


abstract class GUI
{
	public static function answerYesOrNo(string $question) : bool
	{
		$answer = '';

		while ($answer !== 'Y' && $answer !== 'N')
		{
			echo $question . ' (Y/N) ';
			$answer = trim(strtoupper(fgets(STDIN)));
		}

		return $answer === 'Y';
	}
}