<?php

namespace App\Domain\Configurator\Quad\Command;

final class QuadNotFound extends \Exception
{
	/**
	 * NotCompatibleComponent constructor.
	 *
	 */
	public function __construct()
	{
		parent::__construct("QUAD_NOT_FOUND", 404);
	}
}
