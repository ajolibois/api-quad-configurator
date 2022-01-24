<?php

namespace App\Infrastructure\Configurator\IdGenerator;

use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Configurator\Quad\QuadIdGenerator as DomainQuadIdGenerator;
use App\Infrastructure\IdGenerator;

final class AlphaNumericQuadIdGenerator implements DomainQuadIdGenerator
{
	use IdGenerator;

	private const QUAD = 'Q';

	/**
	 * @return QuadId
	 */
	public function generate(): QuadId
	{
		$quadId = (string)time() . $this->randomFast(10, $this->charAlnum) . self::QUAD;
		return new QuadId($quadId);
	}
}
