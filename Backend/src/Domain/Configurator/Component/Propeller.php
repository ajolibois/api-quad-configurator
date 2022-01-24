<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Enum\FrameSize;
use App\Domain\Configurator\Enum\PropellerPitch;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is propeller entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Propeller extends BaseComponent
{
	/**
	 * @var string
	 *
	 * The frame size of propeller
	 *
	 * @ORM\Column(type="string")
	 */
	private string $frameSize;

	/**
	 * @var string
	 *
	 * The pitch of propeller
	 *
	 * @ORM\Column(type="string")
	 */
	private string $propellerPitch;

	/**
	 * @param string $name
	 * @param Money $price
	 * @param FrameSize $frameSize
	 * @param PropellerPitch $propellerPitch
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		string $name,
		Money $price,
		FrameSize $frameSize,
		PropellerPitch $propellerPitch,
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

		$this->frameSize = $frameSize->getValue();
		$this->propellerPitch = $propellerPitch->getValue();
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
		return ComponentType::PROPELLER();
	}

	/**
	 * @return FrameSize
	 */
	public function getFrameSize(): FrameSize
	{
		return new FrameSize($this->frameSize);
	}

	/**
	 * @return PropellerPitch
	 */
	public function getPropellerPitch(): PropellerPitch
	{
		return new PropellerPitch($this->propellerPitch);
	}
}
