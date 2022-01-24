<?php

namespace App\Domain\Configurator\Quad;

use App\Domain\AggregateRoot;
use App\Domain\Configurator\Component\Battery;
use App\Domain\Configurator\Component\Camera;
use App\Domain\Configurator\Component\Component;
use App\Domain\Configurator\Component\Frame;
use App\Domain\Configurator\Component\Motor;
use App\Domain\Configurator\Component\Propeller;
use App\Domain\Configurator\Component\Receptor;
use App\Domain\Configurator\Component\Stack;
use App\Domain\Configurator\Component\Vtx;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Enum\FlightStyle;
use App\Domain\Configurator\NotCompatibleComponent;
use App\Domain\Configurator\Quad\Command\AddComponentToQuad\ComponentWasAddedToQuad;
use App\Domain\Configurator\Quad\Command\CreateQuad\QuadWasCreated;
use App\Domain\Configurator\Quad\Command\LockQuad\QuadWasLocked;
use App\Domain\Configurator\Quad\Command\RemoveComponentToQuad\ComponentWasRemovedToQuad;
use App\Domain\Currency;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is a quad entity.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Quad extends AggregateRoot
{
    /**
     * The id of the quad.
	 *
	 * @var ?QuadId
     *
	 * @ORM\Embedded(class="QuadId", columnPrefix=false)
     */
    public ?QuadId $id = null;

    /**
     *
     * The frame of the quad
     *
     * @var ?Frame
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Frame")
     * @ORM\JoinColumn(name="frame_id", referencedColumnName="id", nullable=true)
     */
    public ?Frame $frame = null;

    /**
     *
     * The battery of the quad
     *
     * @var ?Battery
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Battery")
     * @ORM\JoinColumn(name="battery_id", referencedColumnName="id", nullable=true)
     */
    public ?Battery $battery = null;

    /**
     *
     * The stack of the quad
     *
     * @var ?Stack
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Stack")
     * @ORM\JoinColumn(name="stack_id", referencedColumnName="id", nullable=true)
     */
    public ?Stack $stack = null;

    /**
     *
     * The propellers of the quad
     *
     * @var ?Propeller
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Propeller")
     * @ORM\JoinColumn(name="propeller_id", referencedColumnName="id", nullable=true)
     */
    public ?Propeller $propeller = null;

    /**
     *
     * The vtx of the quad
     *
     * @var ?Vtx
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Vtx")
     * @ORM\JoinColumn(name="vtx_id", referencedColumnName="id", nullable=true)
     */
    public ?Vtx $vtx = null;

    /**
     *
     * The motor of the quad
     *
     * @var ?Motor
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Motor")
     * @ORM\JoinColumn(name="motor_id", referencedColumnName="id", nullable=true)
     */
    public ?Motor $motor = null;

    /**
     *
     * The camera of the quad
     *
     * @var ?Camera
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Camera")
     * @ORM\JoinColumn(name="camera_id", referencedColumnName="id", nullable=true)
     */
    public ?Camera $camera = null;

	/**
	 *
	 * The receptor of the quad
	 *
	 * @var ?Receptor
	 *
	 * @ORM\ManyToOne(targetEntity="App\Domain\Configurator\Component\Receptor")
	 * @ORM\JoinColumn(name="receptor_id", referencedColumnName="id", nullable=true)
	 */
	public ?Receptor $receptor = null;

	/**
	 *
	 * The flight style of the quad
	 *
	 * @var ?string
	 *
	 * @ORM\Column(name="flight_style", nullable=true)
	 */
	public ?string $flightStyle = null;

	/**
	 * @var string
	 *
	 * The component name
	 *
	 * @ORM\Column(type="string")
	 */
	protected string $name;

	/**
	 * @var ?PinCode
	 *
	 * @ORM\Embedded(class="PinCode", columnPrefix=false)
	 */
	private ?PinCode $pinCode = null;

	/**
	 * Quad constructor.
	 *
	 * @param QuadId $id
	 * @param string $name
	 */
	private function __construct(QuadId $id, string $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	/**
	 * @param string $name
	 * @param QuadIdGenerator $quadIdGenerator
	 * @return static
	 */
	public static function createNew(string $name, QuadIdGenerator $quadIdGenerator): self
	{
		$self = new self($quadIdGenerator->generate(), $name);
		$event = new QuadWasCreated($self->getId());
		$self->record($event);
		return $self;
	}

	/**
	 * @param Component $component
	 */
	public function addComponent(Component $component)
	{
		if (!$this->isCompatibleComponent($component)) {
			throw new NotCompatibleComponent($component);
		}

		switch ($component) {
			case $component instanceof Battery:
				$this->battery = $component;
				break;
			case $component instanceof Camera:
				$this->camera = $component;
				break;
			case $component instanceof Frame:
				$this->frame = $component;
				break;
			case $component instanceof Motor:
				$this->motor = $component;
				break;
			case $component instanceof Propeller:
				$this->propeller = $component;
				break;
			case $component instanceof Receptor:
				$this->receptor = $component;
				break;
			case $component instanceof Stack:
				$this->stack = $component;
				break;
			case $component instanceof Vtx:
				$this->vtx = $component;
				break;
			default:
				throw new \InvalidArgumentException('BAD_COMPONENT_TYPE');
		}

		$event = new ComponentWasAddedToQuad($this->getId(), $component->getId());
		$this->record($event);
	}

	/**
	 * @param PinCode $pinCode
	 * @return $this
	 */
	public function lock(PinCode $pinCode): self
	{
		$this->pinCode = $pinCode;
		$event = new QuadWasLocked($this->getId());
		$this->record($event);
		return $this;
	}

	/**
	 * @param ComponentType $componentType
	 * @return Quad
	 */
	public function removeComponent(ComponentType $componentType): self
	{
		switch ($componentType) {
			case ComponentType::MOTOR():
				$component = $this->motor;
				$this->motor = null;
				break;
			case ComponentType::VTX():
				$component = $this->vtx;
				$this->vtx = null;
				break;
			case ComponentType::STACK():
				$component = $this->stack;
				$this->stack = null;
				break;
			case ComponentType::RECEPTOR():
				$component = $this->receptor;
				$this->receptor = null;
				break;
			case ComponentType::PROPELLER():
				$component = $this->propeller;
				$this->propeller = null;
				break;
			case ComponentType::FRAME():
				$component = $this->frame;
				$this->frame = null;
				break;
			case ComponentType::CAMERA():
				$component = $this->camera;
				$this->camera = null;
				break;
			case ComponentType::BATTERY():
				$component = $this->battery;
				$this->battery = null;
				break;
			default:
				return $this;
		}

		if (!$component instanceof Component) {
			return $this;
		}

		$event = new ComponentWasRemovedToQuad($this->getId(), $component->getId());
		$this->record($event);

		return $this;
	}

	/**
	 * @param Component $component
	 * @return bool
	 */
	public function isCompatibleComponent(Component $component): bool
	{
		foreach($this as $key => $value) {
			if ($value instanceof Component) {
				if (!$value->isCompatibleComponent($component)) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * @return PinCode
	 */
	public function getPinCode(): PinCode
	{
		return $this->pinCode;
	}

    /**
     * @return ?QuadId
     */
    public function getId(): ?QuadId
    {
        return $this->id;
    }

    /**
     * @return ?Frame
     */
    public function getFrame(): ?Frame
    {
        return $this->frame;
    }

    /**
     * @return ?Battery
     */
    public function getBattery(): ?Battery
    {
        return $this->battery;
    }

    /**
     * @return ?Stack
     */
    public function getStack(): ?Stack
    {
        return $this->stack;
    }

    /**
     * @return ?Propeller
     */
    public function getPropeller(): ?Propeller
    {
        return $this->propeller;
    }

    /**
     * @return ?Vtx
     */
    public function getVtx(): ?Vtx
    {
        return $this->vtx;
    }

    /**
     * @return ?Motor
     */
    public function getMotor(): ?Motor
    {
        return $this->motor;
    }

    /**
     * @return ?Camera
     */
    public function getCamera(): ?Camera
    {
        return $this->camera;
    }

	/**
	 * @return ?Receptor
	 */
	public function getReceptor(): ?Receptor
	{
		return $this->receptor;
	}

	/**
	 * @return FlightStyle
	 */
	public function getFlightStyle(): FlightStyle
	{
		return new FlightStyle($this->flightStyle);
	}

	/**
	 * @return Money
	 */
	public function getPrice(): Money
	{
		$price = Money::createNull(Currency::EUR());
		foreach($this as $key => $value) {
			if ($value instanceof Component) {
				$price->add($value->getPrice());
			}
		}

		return $price;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function isLocked(): bool
	{
		return $this->pinCode->getValue() !== null;
	}

	public function removePin(): void
	{
		$this->pinCode = null;
	}
}
