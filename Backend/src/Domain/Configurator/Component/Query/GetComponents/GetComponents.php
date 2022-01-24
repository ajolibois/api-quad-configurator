<?php

namespace App\Domain\Configurator\Component\Query\GetComponents;

use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Query;

final class GetComponents implements Query
{
	/**
	 * GetComponents constructor.
	 *
	 * @param ComponentType $componentType
	 */
	public function __construct(private ComponentType $componentType) { }

	/**
	 * @return ComponentType
	 */
	public function getComponentType(): ComponentType
	{
		return $this->componentType;
	}
}
