<?php

namespace App\Domain\Configurator\Enum;

use App\Domain\Enum;

/**
 * @method static AntennaConnection UFL()
 * @method static AntennaConnection MMCX()
 */
final class AntennaConnection extends Enum
{
	private const UFL = "UFL";
	private const MMCX = "MMCX";
}
