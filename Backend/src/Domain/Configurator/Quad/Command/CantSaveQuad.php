<?php

namespace App\Domain\Configurator\Quad\Command;

final class CantSaveQuad extends \RuntimeException
{
	/**
	 * NotCompatibleComponent constructor.
	 *
	 */
	public function __construct()
	{
		parent::__construct("CANT_SAVE_QUAD", 500);
	}
}
