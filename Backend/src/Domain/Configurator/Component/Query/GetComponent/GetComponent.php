<?php

namespace App\Domain\Configurator\Component\Query\GetComponent;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Query;

final class GetComponent implements Query
{
	/**
	 * GetComponent constructor.
	 *
	 * @param ComponentId $componentId
	 * @param ComponentType $componentType
	 */
	public function __construct(
		private ComponentId $componentId,
		private ComponentType $componentType
	) { }

	/**
	 * @return ComponentId
	 */
	public function getComponentId(): ComponentId
	{
		return $this->componentId;
	}

	/**
	 * @return ComponentType
	 */
	public function getComponentType(): ComponentType
	{
		return $this->componentType;
	}
}
