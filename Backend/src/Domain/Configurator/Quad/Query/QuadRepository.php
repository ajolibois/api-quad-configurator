<?php

namespace App\Domain\Configurator\Quad\Query;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Configurator\Quad\QuadId;

interface QuadRepository
{
	/**
	 * @param QuadId $quadId
	 * @return Quad
	 */
	public function find(QuadId $quadId): Quad;

	/**
	 * @return Quad[]
	 */
	public function getAllList(): array;
}
