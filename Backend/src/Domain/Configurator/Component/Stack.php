<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Enum\EscMaxCurrent;
use App\Domain\Configurator\Enum\FlightControllerProc;
use App\Domain\Configurator\Enum\StackHole;
use App\Domain\Configurator\Enum\UartCount;
use App\Domain\Configurator\Enum\VtxInputPower;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is esc entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Stack extends BaseComponent
{
	/**
	 * @var string
	 *
	 * The output power of FC for vtx
	 *
	 * @ORM\Column(type="string")
	 */
	private string $vtxOutputPower;

	/**
	 * @var string
	 *
	 * The proc of fc
	 *
	 * @ORM\Column(type="string")
	 */
	private string $flightControllerProc;

	/**
	 * @var string
	 *
	 * The hole of stack
	 *
	 * @ORM\Column(type="string")
	 */
	private string $stackHole;

	/**
	 * @var string
	 *
	 * The uart count of stack
	 *
	 * @ORM\Column(type="string")
	 */
	private string $uartCount;

	/**
	 * @var boolean
	 *
	 * The numeric compatibility of stack
	 *
	 * @ORM\Column(type="boolean")
	 */
	private bool $isNumericCompatible;

	/**
	 * @var boolean
	 *
	 * The analogic compatibility of stack
	 *
	 * @ORM\Column(type="boolean")
	 */
	private bool $isAnalogCompatible;

	/**
	 * @var string
	 *
	 * The esc max current of stack
	 *
	 * @ORM\Column(type="string")
	 */
	private string $escMaxCurrent;

	/**
	 * @param string $name
	 * @param Money $price
	 * @param VtxInputPower $vtxInputPower
	 * @param FlightControllerProc $flightControllerProc
	 * @param StackHole $stackHole
	 * @param UartCount $uartCount
	 * @param bool $isNumericCompatible
	 * @param bool $isAnalogCompatible
	 * @param EscMaxCurrent $escMaxCurrent
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		string $name,
		Money $price,
		VtxInputPower $vtxInputPower,
		FlightControllerProc $flightControllerProc,
		StackHole $stackHole,
		UartCount $uartCount,
		bool $isNumericCompatible,
		bool $isAnalogCompatible,
		EscMaxCurrent $escMaxCurrent,
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

		$this->vtxOutputPower = $vtxInputPower->getValue();
		$this->flightControllerProc = $flightControllerProc->getValue();
		$this->stackHole = $stackHole->getValue();
		$this->uartCount = $uartCount->getValue();
		$this->isNumericCompatible = $isNumericCompatible;
		$this->isAnalogCompatible = $isAnalogCompatible;
		$this->escMaxCurrent = $escMaxCurrent->getValue();
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
		return ComponentType::STACK();
	}

	/**
	 * @return VtxInputPower
	 */
	public function getVtxOutputPower(): VtxInputPower
	{
		return new VtxInputPower($this->vtxOutputPower);
	}

	/**
	 * @return FlightControllerProc
	 */
	public function getFlightControllerProc(): FlightControllerProc
	{
		return new FlightControllerProc($this->flightControllerProc);
	}

	/**
	 * @return StackHole
	 */
	public function getStackHole(): StackHole
	{
		return new StackHole($this->stackHole);
	}

	/**
	 * @return UartCount
	 */
	public function getUartCount(): UartCount
	{
		return new UartCount($this->uartCount);
	}

	/**
	 * @return bool
	 */
	public function isNumericCompatible(): bool
	{
		return $this->isNumericCompatible;
	}

	/**
	 * @return bool
	 */
	public function isAnalogCompatible(): bool
	{
		return $this->isAnalogCompatible;
	}

	/**
	 * @return EscMaxCurrent
	 */
	public function getEscMaxCurrent(): EscMaxCurrent
	{
		return new EscMaxCurrent($this->escMaxCurrent);
	}
}
