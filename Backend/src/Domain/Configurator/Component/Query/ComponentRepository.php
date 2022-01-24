<?php

namespace App\Domain\Configurator\Component\Query;

use App\Domain\Configurator\Component\Component;
use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Quad\Quad;

interface ComponentRepository
{
	/**
	 * @param Quad $quad
	 * @param ComponentType $componentType
	 * @return Component[]
	 */
	public function getCompatibleComponents(Quad $quad, ComponentType $componentType): array;

	/**
	 * @param ComponentId $componentId
	 * @param ComponentType $componentType
	 * @return Component
	 */
	public function find(ComponentId $componentId, ComponentType $componentType): Component;

	/**
	 * @param ComponentType $componentType
	 * @return Component[]
	 */
	public function getList(ComponentType $componentType): array;
}
