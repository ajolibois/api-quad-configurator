<?php

namespace App\Domain\Configurator\Component\Command\UpdateComponent;

use App\Domain\Command;
use App\Domain\Configurator\Component\Component;

final class UpdateComponent implements Command
{
	/**
	 * AddComponent constructor.
	 *
	 * @param Component $component
	 */
	public function __construct(private Component $component) { }

	/**
	 * @return Component
	 */
	public function getComponent(): Component
	{
		return $this->component;
	}
}
