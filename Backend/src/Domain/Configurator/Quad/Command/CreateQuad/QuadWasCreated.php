<?php

namespace App\Domain\Configurator\Quad\Command\CreateQuad;

use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Event;

final class QuadWasCreated implements Event
{
	/**
	 * QuadWasCreated constructor.
	 *
	 * @param QuadId $quadId
	 */
	public function __construct(private QuadId $quadId) { }

	/**
	 * @return QuadId
	 */
	public function getQuadId(): QuadId
	{
		return $this->quadId;
	}
}
