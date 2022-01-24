<?php

namespace App\Domain\Configurator\Component\Command;

use App\Domain\Configurator\Component\Component;
use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Enum\ComponentType;

interface ComponentRepository
{
	/**
	 * @param Component $component
	 */
	public function save(Component $component): void;

	/**
	 * @param ComponentId $componentId
	 * @param ComponentType $componentType
	 * @return Component
	 */
	public function find(ComponentId $componentId, ComponentType $componentType): Component;
}
