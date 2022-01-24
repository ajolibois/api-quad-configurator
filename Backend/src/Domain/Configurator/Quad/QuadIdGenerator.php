<?php

namespace App\Domain\Configurator\Quad;

interface QuadIdGenerator
{
	/**
	 * @return QuadId
	 */
	public function generate(): QuadId;
}
