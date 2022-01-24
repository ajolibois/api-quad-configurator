<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\BatteryC;
use App\Domain\Configurator\Enum\BatteryCellCount;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is battery entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Battery extends BaseComponent
{
	/**
	 * @var string
	 *
	 * The nb cell of battery
	 *
	 * @ORM\Column(type="string")’
	 */
	private string $cellCount;

	/**
	 * @var string
	 *
	 * The c of battery
	 *
	 * @ORM\Column(type="string")
	 */
	private string $c;

	/**
	 * @param string $name
	 * @param Money $price
	 * @param BatteryCellCount $cellCount
	 * @param BatteryC $c
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		string $name,
		Money $price,
		BatteryCellCount $cellCount,
		BatteryC $c,
		bool $isFavorite,
		string $imgUrl,
		string $tags,
		string $description,
		ComponentDiscriminator $componentDiscriminator
	) {
		parent::__construct(
			$name,
			$price,
			$isFavorite,
			$imgUrl,
			$tags,
			$description,
			$componentDiscriminator
		);

		$this->cellCount = $cellCount->getValue();
		$this->c = $c->getValue();
	}

	/**
     * @param Component $component
     * @return bool
     */
    public function isCompatibleComponent(Component $component): bool
    {
        return true;
    }

	/**
	 * @return ComponentType
	 */
	public function getType(): ComponentType
	{
		return ComponentType::BATTERY();
	}

	/**
	 * @return BatteryCellCount
	 */
	public function getCellCount(): BatteryCellCount
	{
		return new BatteryCellCount($this->cellCount);
	}

	/**
	 * @return BatteryC
	 */
	public function getC(): BatteryC
	{
		return new BatteryC($this->c);
	}
}
