<?php

namespace App\Domain\Configurator\Enum;

use App\Domain\Enum;

/**
 * @method static CameraSize MINI()
 * @method static CameraSize MICRO()
 * @method static CameraSize NANO()
 * @method static CameraSize FULL()
 */
final class CameraSize extends Enum
{
	private const MINI = "MINI";
	private const MICRO = "MICRO";
	private const NANO = "NANO";
	private const FULL = "FULL";
}
