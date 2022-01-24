<?php

namespace App\Infrastructure\Configurator\IdGenerator;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Component\Service\ComponentIdGenerator as DomainComponentIdGenerator;
use App\Domain\Configurator\Enum\ComponentType;
use App\Infrastructure\IdGenerator;

final class AlphaNumericComponentIdGenerator implements DomainComponentIdGenerator
{
	use IdGenerator;

	/**
	 * @param ComponentType $componentType
	 * @return ComponentId
	 */
	public function generate(ComponentType $componentType): ComponentId
	{
		// Warning ! We can't add component with same first letter
		$lastChar = $this->getlastCharOfComponentTypeKey($componentType->getKey());
		$componentId = (string)time() . $this->randomFast(10, $this->charAlnum) . $lastChar;
		return new ComponentId($componentId);
	}

	/**
	 * @param string $componentTypeKey
	 * @return string
	 */
	public function getlastCharOfComponentTypeKey(string $componentTypeKey): string
	{
		if (!ComponentType::isValidKey($componentTypeKey)) {
			throw new \LogicException(sprintf(
				'"%s" is invalid key of component type enum',
				$componentTypeKey
			));
		}

		return strtoupper(substr($componentTypeKey, 0, 1));
	}
}
