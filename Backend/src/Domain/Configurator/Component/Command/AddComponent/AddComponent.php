<?php

namespace App\Domain\Configurator\Component\Command\AddComponent;

use App\Domain\Command;
use App\Domain\Configurator\Component\Component;

final class AddComponent implements Command
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
