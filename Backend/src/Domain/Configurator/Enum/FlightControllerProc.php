<?php

namespace App\Domain\Configurator\Enum;

use App\Domain\Enum;

/**
 * @method static FlightControllerProc F3()
 * @method static FlightControllerProc F4()
 * @method static FlightControllerProc F5()
 * @method static FlightControllerProc F7()
 * @method static FlightControllerProc H7()
 */
final class FlightControllerProc extends Enum
{
	private const F3 = "F3";
	private const F4 = "F4";
	private const F5 = "F5";
	private const F7 = "F7";
	private const H7 = "H7";
}
