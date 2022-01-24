<?php

namespace App\Domain\Configurator\Enum;

use App\Domain\Enum;

/**
 * @method static FlightStyle RACE()
 * @method static FlightStyle FREESTYLE()
 * @method static FlightStyle CINEMATIC()
 * @method static FlightStyle FREESTYLE_CINEMATIC()
 */
final class FlightStyle extends Enum
{
	private const RACE = "RACE";
	private const FREESTYLE = "FREESTYLE";
	private const CINEMATIC = "CINEMATIC";
	private const FREESTYLE_CINEMATIC = "FREESTYLE_CINEMATIC";
}
