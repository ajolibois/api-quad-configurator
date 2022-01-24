<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\AntennaConnection;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Enum\VtxHole;
use App\Domain\Configurator\Enum\VtxInputPower;
use App\Domain\Configurator\Enum\VtxPower;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is vtx entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Vtx extends BaseComponent
{
	/**
	 * @var string
	 *
	 * The nb hole of Vtx
	 *
	 * @ORM\Column(type="string")
	 */
	private string $vtxHole;

	/**
	 * @var boolean
	 *
	 * is numeric Vtx ?
	 *
	 * @ORM\Column(type="boolean")
	 */
	private bool $isNumeric;

	/**
	 * @var string
	 *
	 * The antenna connection of Vtx
	 *
	 * @ORM\Column(type="string")
	 */
	private string $antennaConnection;

	/**
	 * @var string
	 *
	 * The power of Vtx
	 *
	 * @ORM\Column(type="string")
	 */
	private string $vtxPower;

	/**
	 * @var string
	 *
	 * The input power of Vtx
	 *
	 * @ORM\Column(type="string")
	 */
	private string $vtxInputPower;

	/**
	 * @param string $name
	 * @param Money $price
	 * @param VtxHole $vtxHole
	 * @param bool $isNumeric
	 * @param AntennaConnection $antennaConnection
	 * @param VtxPower $vtxPower
	 * @param VtxInputPower $vtxInputPower
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		string $name,
		Money $price,
		VtxHole $vtxHole,
		bool $isNumeric,
		AntennaConnection $antennaConnection,
		VtxPower $vtxPower,
		VtxInputPower $vtxInputPower,
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

		$this->vtxHole = $vtxHole->getValue();
		$this->isNumeric = $isNumeric;
		$this->antennaConnection = $antennaConnection->getValue();
		$this->vtxPower = $vtxPower->getValue();
		$this->vtxInputPower = $vtxInputPower->getValue();
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
		return ComponentType::VTX();
	}

	/**
	 * @return VtxHole
	 */
	public function getVtxHole(): VtxHole
	{
		return new VtxHole($this->vtxHole);
	}

	/**
	 * @return bool
	 */
	public function isNumeric(): bool
	{
		return $this->isNumeric;
	}

	/**
	 * @return AntennaConnection
	 */
	public function getAntennaConnection(): AntennaConnection
	{
		return new AntennaConnection($this->antennaConnection);
	}

	/**
	 * @return VtxPower
	 */
	public function getVtxPower(): VtxPower
	{
		return new VtxPower($this->vtxPower);
	}

	/**
	 * @return VtxInputPower
	 */
	public function getVtxInputPower(): VtxInputPower
	{
		return new VtxInputPower($this->vtxInputPower);
	}
}
