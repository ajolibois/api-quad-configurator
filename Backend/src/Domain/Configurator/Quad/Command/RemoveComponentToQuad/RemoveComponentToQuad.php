<?php

namespace App\Domain\Configurator\Quad\Command\RemoveComponentToQuad;

use App\Domain\Command;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Quad\PinCode;
use App\Domain\Configurator\Quad\QuadId;

final class RemoveComponentToQuad implements Command
{
	/**
	 * RemoveComponentToQuad constructor.
	 *
	 * @param QuadId $quadId
	 * @param ComponentType $componentType
	 * @param PinCode|null $pinCode
	 */
	public function __construct(
		private QuadId $quadId,
		private ComponentType $componentType,
		private ?PinCode $pinCode
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

	/**
	 * @return PinCode|null
	 */
	public function getPinCode(): ?PinCode
	{
		return $this->pinCode;
	}
}
