<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\CameraSize;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Enum\FrameSize;
use App\Domain\Configurator\Enum\StackHole;
use App\Domain\Configurator\Enum\FrameArmThickness;
use App\Domain\Configurator\Enum\VtxHole;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is motor entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Frame extends BaseComponent
{
	/**
	 * @var string
	 *
	 * The frame size of frame
	 *
	 * @ORM\Column(type="string")
	 */
	private string $frameSize;

	/**
	 * @var string
	 *
	 * The thickness arm of frame
	 *
	 * @ORM\Column(type="string")
	 */
	private string $armThickness;

	/**
	 * @var string
	 *
	 * The nb vtx hole of frame
	 *
	 * @ORM\Column(type="string")
	 */
	private string $vtxHole;

	/**
	 * @var string
	 *
	 * The camera size of frame
	 *
	 * @ORM\Column(type="string")
	 */
	private string $cameraSize;

	/**
	 * @var string
	 *
	 * The camera size of frame
	 *
	 * @ORM\Column(type="string")
	 */
	private string $stackHole;

	/**
	 * @param string $name
	 * @param Money $price
	 * @param FrameSize $frameSize
	 * @param FrameArmThickness $armThickness
	 * @param VtxHole $vtxHole
	 * @param CameraSize $cameraSize
	 * @param StackHole $stackHole
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
		FrameArmThickness $armThickness,
		VtxHole $vtxHole,
		CameraSize $cameraSize,
		StackHole $stackHole,
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
		$this->armThickness = $armThickness->getValue();
		$this->vtxHole = $vtxHole->getValue();
		$this->cameraSize = $cameraSize->getValue();
		$this->stackHole = $stackHole->getValue();
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
		return ComponentType::FRAME();
	}

	/**
	 * @return FrameSize
	 */
	public function getFrameSize(): FrameSize
	{
		return new FrameSize($this->frameSize);
	}

	/**
	 * @return FrameArmThickness
	 */
	public function getArmThickness(): FrameArmThickness
	{
		return new FrameArmThickness($this->armThickness);
	}

	/**
	 * @return VtxHole
	 */
	public function getVtxHole(): VtxHole
	{
		return new VtxHole($this->vtxHole);
	}

	/**
	 * @return CameraSize
	 */
	public function getCameraSize(): CameraSize
	{
		return new CameraSize($this->cameraSize);
	}

	/**
	 * @return StackHole
	 */
	public function getStackHole(): StackHole
	{
		return new StackHole($this->stackHole);
	}
}
