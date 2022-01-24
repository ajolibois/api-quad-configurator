<?php

namespace App\Domain\Configurator\Component\Query\GetCompatibleComponents;

use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Query;

final class GetCompatibleComponents implements Query
{
	/**
	 * GetCompatibleComponents constructor.
	 *
	 * @param QuadId $quadId
	 * @param ComponentType $componentType
	 */
	public function __construct(
		private QuadId $quadId,
		private ComponentType $componentType
	) { }

	/**
	 * @return QuadId
	 */
	public function getQuadId(): QuadId
	{
		return $this->quadId;
	}

	/**
	 * @return ComponentType
	 */
	public function getComponentType(): ComponentType
	{
		return $this->componentType;
	}
}
