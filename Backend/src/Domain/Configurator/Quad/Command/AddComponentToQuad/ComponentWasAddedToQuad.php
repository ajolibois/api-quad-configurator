<?php

namespace App\Domain\Configurator\Quad\Command\AddComponentToQuad;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Event;

final class ComponentWasAddedToQuad implements Event
{
	/**
	 * ComponentWasAddedToQuad constructor.
	 *
	 * @param QuadId $quadId
	 * @param ComponentId $componentId
	 */
	public function __construct(private QuadId $quadId, private ComponentId $componentId) { }

	/**
	 * @return QuadId
	 */
	public function getQuadId(): QuadId
	{
		return $this->quadId;
	}

	/**
	 * @return ComponentId
	 */
	public function getComponentId(): ComponentId
	{
		return $this->componentId;
	}
}
