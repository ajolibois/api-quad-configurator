<?php

namespace App\Domain\Configurator\Enum;

use App\Domain\Enum;

/**
 * @method static VtxPower MW25()
 * @method static VtxPower MW100()
 * @method static VtxPower MW200()
 * @method static VtxPower MW400()
 * @method static VtxPower MW500()
 * @method static VtxPower MW600()
 * @method static VtxPower MW700()
 * @method static VtxPower MW800()
 * @method static VtxPower MW900()
 * @method static VtxPower MW1000()
 * @method static VtxPower MW1200()
 * @method static VtxPower MW1400()
 * @method static VtxPower MW1600()
 */
final class VtxPower extends Enum
{
	private const MW25 = "25";
	private const MW100 = "30";
	private const MW200 = "200";
	private const MW400 = "400";
	private const MW500 = "500";
	private const MW600 = "600";
	private const MW700 = "700";
	private const MW800 = "800";
	private const MW900 = "900";
	private const MW1000 = "1000";
	private const MW1200 = "1200";
	private const MW1400 = "1400";
	private const MW1600 = "1600";
}
