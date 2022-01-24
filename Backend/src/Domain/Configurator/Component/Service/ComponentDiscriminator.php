<?php

namespace App\Domain\Configurator\Component\Service;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Enum\ComponentType;

interface ComponentDiscriminator
{
	/**
	 * @param ComponentId $componentId
	 * @param ComponentType $componentType
	 * @return bool
	 */
	public static function isIdOfComponentType(ComponentId $componentId, ComponentType $componentType): bool;

	/**
	 * @param ComponentId $componentId
	 * @return bool
	 */
	public static function isValidComponentId(ComponentId $componentId): bool;

	/**
	 * @param ComponentId $componentId
	 * @return ?ComponentType
	 */
	public static function getComponentTypeByComponentId(ComponentId $componentId): ?ComponentType;
}
