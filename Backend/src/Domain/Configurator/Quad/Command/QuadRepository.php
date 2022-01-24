<?php

namespace App\Domain\Configurator\Quad\Command;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Configurator\Quad\QuadId;

interface QuadRepository
{
	/**
	 * @param Quad $quad
	 */
	public function save(Quad $quad): void;

	/**
	 * @param QuadId $quadId
	 * @return Quad
	 */
	public function find(QuadId $quadId): Quad;
}
