<?php

namespace App\Domain\Configurator\Component\Service;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Enum\ComponentType;

interface ComponentIdGenerator
{
	/**
	 * @param ComponentType $componentType
	 * @return ComponentId
	 */
	public function generate(ComponentType $componentType): ComponentId;
}
