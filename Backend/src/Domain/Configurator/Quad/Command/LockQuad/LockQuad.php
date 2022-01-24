<?php

namespace App\Domain\Configurator\Quad\Command\LockQuad;

use App\Domain\Command;
use App\Domain\Configurator\Quad\PinCode;
use App\Domain\Configurator\Quad\QuadId;

final class LockQuad implements Command
{
	/**
	 * ValidateQuad constructor.
	 *
	 * @param QuadId $quadId
	 * @param PinCode $pinCode
	 */
	public function __construct(private QuadId $quadId, private PinCode $pinCode) { }

	/**
	 * @return QuadId
	 */
	public function getQuadId(): QuadId
	{
		return $this->quadId;
	}

	/**
	 * @return PinCode
	 */
	public function getPinCode(): PinCode
	{
		return $this->pinCode;
	}
}
