<?php

namespace App\Domain\Configurator\Component\Command\UpdateComponent;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Event;

final class ComponentWasUpdated implements Event
{
	/**
	 * ComponentWasUpdated constructor.
	 *
	 * @param ComponentId $componentId
	 */
	public function __construct(private ComponentId $componentId) { }

	/**
	 * @return ComponentId
	 */
	public function getComponentId(): ComponentId
	{
		return $this->componentId;
	}
}
