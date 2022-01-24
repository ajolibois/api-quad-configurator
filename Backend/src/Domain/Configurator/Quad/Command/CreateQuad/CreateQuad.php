<?php

namespace App\Domain\Configurator\Quad\Command\CreateQuad;

use App\Domain\Command;

final class CreateQuad implements Command
{
	/**
	 * CreateQuad constructor.
	 *
	 * @param string $name
	 */
	public function __construct(private string $name) { }

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}
}
