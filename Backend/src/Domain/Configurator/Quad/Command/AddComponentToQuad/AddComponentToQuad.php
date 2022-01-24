<?php

namespace App\Domain\Configurator\Quad\Command\AddComponentToQuad;

use App\Domain\Command;
use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Quad\PinCode;
use App\Domain\Configurator\Quad\QuadId;

final class AddComponentToQuad implements Command
{
	/**
	 * AddComponentToQuad constructor.
	 *
	 * @param QuadId $quadId
	 * @param ComponentId $componentId
	 * @param ?PinCode $pinCode
	 */
	public function __construct(
		private QuadId $quadId,
		private ComponentId $componentId,
		private ?PinCode $pinCode = null
	) { }

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

	/**
	 * @return ?PinCode
	 */
	public function getPinCode(): ?PinCode
	{
		return $this->pinCode;
	}
}
