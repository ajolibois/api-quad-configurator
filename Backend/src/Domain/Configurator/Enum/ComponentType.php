<?php

namespace App\Domain\Configurator\Enum;

use App\Domain\Enum;

/**
 * @method static ComponentType BATTERY()
 * @method static ComponentType CAMERA()
 * @method static ComponentType FRAME()
 * @method static ComponentType MOTOR()
 * @method static ComponentType PROPELLER()
 * @method static ComponentType RECEPTOR()
 * @method static ComponentType STACK()
 * @method static ComponentType VTX()
 */
final class ComponentType extends Enum
{
	private const BATTERY = "BATTERY";
	private const CAMERA = "CAMERA";
	private const FRAME = "FRAME";
	private const MOTOR = "MOTOR";
	private const PROPELLER = "PROPELLER";
	private const RECEPTOR = "RECEPTOR";
	private const STACK = "STACK";
	private const VTX = "VTX";
}
