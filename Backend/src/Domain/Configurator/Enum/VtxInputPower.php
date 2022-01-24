<?php

namespace App\Domain\Configurator\Enum;

use App\Domain\Enum;

/**
 * @method static VtxInputPower V5()
 * @method static VtxInputPower V9()
 * @method static VtxInputPower V10()
 * @method static VtxInputPower VCC()
 */
final class VtxInputPower extends Enum
{
	private const V5 = "5";
	private const V9 = "9";
	private const V10 = "10";
	private const VCC = "VCC";
}
