<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\CameraSize;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is Receptor entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Camera extends BaseComponent
{
	/**
	 * @var string
	 *
	 * The nb cell of battery
	 *
	 * @ORM\Column(type="string")
	 */
	private string $cameraSize;

	/**
	 * @var boolean
	 *
	 * The nb cell of battery
	 *
	 * @ORM\Column(type="boolean")
	 */
	private bool $isNumeric;

	/**
	 * @param string $name
	 * @param Money $price
	 * @param CameraSize $cameraSize
	 * @param bool $isNumeric
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		string $name,
		Money $price,
		CameraSize $cameraSize,
		bool $isNumeric,
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

		$this->cameraSize = $cameraSize->getValue();
		$this->isNumeric = $isNumeric;
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
		return ComponentType::CAMERA();
	}

	/**
	 * @return CameraSize
	 */
	public function getCameraSize(): CameraSize
	{
		return new CameraSize($this->cameraSize);
	}

	/**
	 * @return bool
	 */
	public function isNumeric(): bool
	{
		return $this->isNumeric;
	}
}
