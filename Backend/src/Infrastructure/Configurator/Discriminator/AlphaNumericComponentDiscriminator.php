<?php

namespace App\Infrastructure\Configurator\Discriminator;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator as DomainComponentDiscriminator;
use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Enum\ComponentType;

final class AlphaNumericComponentDiscriminator implements DomainComponentDiscriminator
{
	/**
	 * @param ComponentId $componentId
	 * @param ComponentType $componentType
	 * @return bool
	 */
	public static function isIdOfComponentType(ComponentId $componentId, ComponentType $componentType): bool
	{
		return self::getComponentTypeByComponentId($componentId)->equals($componentType);
	}

	/**
	 * @param ComponentId $componentId
	 * @return bool
	 */
	public static function isValidComponentId(ComponentId $componentId): bool
	{
		return self::getComponentTypeByComponentId($componentId) !== null;
	}

	/**
	 * @param ComponentId $componentId
	 * @return ?ComponentType
	 */
	public static function getComponentTypeByComponentId(ComponentId $componentId): ?ComponentType
	{
		$lastChar = substr($componentId->getValue(), -1);

		switch ($lastChar) {
			case 'B':
				return ComponentType::BATTERY();
			case 'C':
				return ComponentType::CAMERA();
			case 'F':
				return ComponentType::FRAME();
			case 'M':
				return ComponentType::MOTOR();
			case 'P':
				return ComponentType::PROPELLER();
			case 'R':
				return ComponentType::RECEPTOR();
			case 'S':
				return ComponentType::STACK();
			case 'V':
				return ComponentType::VTX();
			default:
				return null;
		}
	}
}
