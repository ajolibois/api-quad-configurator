<?php
declare(strict_types=1);

namespace App\Infrastructure;

trait IdGenerator
{
	private $charNum = 1;
	private $charAlpha = 2;
	private $charAlnum = 3;
	private $allNumbers = '0123456789';
	private $allLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	private function randomFast($length, $mask = null): string
	{
		if ($mask === null) {
			$mask = $this->charAlnum;
		}

		$token = '';

		$codeAlphabet = '';

		if ($this->charAlpha === ($mask & $this->charAlpha)) {
			$codeAlphabet .= $this->allLetters;
		}

		if ($this->charNum === ($mask & $this->charNum)) {
			$codeAlphabet .= $this->allNumbers;
		}

		for ($i = 0; $i < $length; $i++) {
			$token .= $codeAlphabet[rand(0, strlen($codeAlphabet) - 1)];
		}

		return $token;
	}
}
