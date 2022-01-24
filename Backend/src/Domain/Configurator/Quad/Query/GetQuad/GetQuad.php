<?php

namespace App\Domain\Configurator\Quad\Query\GetQuad;

use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Query;

final class GetQuad implements Query
{
	/**
	 * GetQuad constructor.
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
