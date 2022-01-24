<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\FlightStyle;
use \App\Domain\Configurator\Enum\MotorKv;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Enum\MotorStatorSize;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is motor entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Motor extends BaseComponent
{
	/**
	 * @var string
	 *
	 * The kv of the motor
	 *
	 * @ORM\Column(type="string")
	 */
	private string $kv;

	/**
	 * @var string
	 *
	 * The stator size of the motor
	 *
	 * @ORM\Column(type="string")
	 */
	private string $statorSize;

	/**
	 * @var string
	 *
	 * The flight style of the motor
	 *
	 * @ORM\Column(type="string")
	 */
	private string $flightStyle;

	/**
	 * @param string $name
	 * @param Money $price
	 * @param MotorKv $kv
	 * @param MotorStatorSize $statorSize
	 * @param FlightStyle $flightStyle
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		string $name,
		Money $price,
		MotorKv $kv,
		MotorStatorSize $statorSize,
		FlightStyle $flightStyle,
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

		$this->kv = $kv->getValue();
		$this->statorSize = $statorSize->getValue();
		$this->flightStyle = $flightStyle->getValue();
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
		return ComponentType::MOTOR();
	}

	/**
	 * @return MotorKv
	 */
	public function getKv(): MotorKv
	{
		return new MotorKv($this->kv);
	}

	/**
	 * @return MotorStatorSize
	 */
	public function getStatorSize(): MotorStatorSize
	{
		return new MotorStatorSize($this->statorSize);
	}

	/**
	 * @return FlightStyle
	 */
	public function getFlightStyle(): FlightStyle
	{
		return new FlightStyle($this->flightStyle);
	}
}
