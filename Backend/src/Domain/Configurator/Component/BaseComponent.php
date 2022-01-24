<?php

namespace App\Domain\Configurator\Component;

use App\Domain\AggregateRoot;
use App\Domain\Configurator\Component\Command\AddComponent\ComponentWasAdded;
use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Component\Service\ComponentIdGenerator;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

abstract class BaseComponent extends AggregateRoot implements Component
{
	/**
	 * @var ?ComponentId
	 *
	 * The component id
	 *
	 * @ORM\Embedded(class="ComponentId", columnPrefix=false)
	 */
	protected ?ComponentId $id = null;

	/**
	 * @var string
	 *
	 * The component name
	 *
	 * @ORM\Column(type="string")
	 */
	protected string $name;

	/**
	 * @var string
	 *
	 * The component price
	 *
	 * @ORM\Column(type="string")
	 */
	protected string $price;

	/**
	 * @var boolean
	 *
	 * is favorite component
	 *
	 * @ORM\Column(type="boolean")
	 */
	protected bool $isFavorite = false;

	/**
	 * @var string
	 *
	 * The component image url
	 *
	 * @ORM\Column(type="string")
	 */
	protected string $imgUrl;

	/**
	 * @var string
	 *
	 * The component tags
	 *
	 * @ORM\Column(type="string")
	 */
	protected string $tags;

	/**
	 * @var string
	 *
	 * The component description
	 *
	 * @ORM\Column(type="string")
	 */
	protected string $description;

	/**
	 * BaseComponent constructor.
	 *
	 * @param string $name
	 * @param Money $money
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	protected function __construct(
		string $name,
		Money $money,
		bool $isFavorite,
		string $imgUrl,
		string $tags,
		string $description,
		private ComponentDiscriminator $componentDiscriminator
	) {
		$this->name = $name;
		$this->price = (string) $money;
		$this->isFavorite = $isFavorite;
		$this->imgUrl = $imgUrl;
		$this->tags = $tags;
		$this->description = $description;
	}

	/**
	 * @return ComponentType
	 */
	abstract public function getType(): ComponentType;

	/**
	 * @return ComponentId|null
	 */
	public function getId(): ?ComponentId
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return Money
	 */
	public function getPrice(): Money
	{
		return Money::createFromString($this->price);
	}


	/**
	 * @return string
	 */
	public function getImgUrl(): string
	{
		return $this->imgUrl;
	}

	/**
	 * @return string
	 */
	public function getTags(): string
	{
		return $this->tags;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param ComponentId $componentId
	 */
	private function setId(ComponentId $componentId): void
	{
		if (!$this->componentDiscriminator->isIdOfComponentType($componentId, $this->getType())) {
			throw new \LogicException(sprintf(
				"Id #%s is not compatible with component type %s",
				$componentId->getValue(),
				$this->getType()->getValue()
			));
		}

		$this->id = $componentId;
	}

	/**
	 * @param ComponentIdGenerator $componentIdGenerator
	 * @return $this
	 */
	public function addNew(ComponentIdGenerator $componentIdGenerator): self
	{
		$this->setId($componentIdGenerator->generate($this->getType()));

		$this->record(new ComponentWasAdded($this->getId()));

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isFavorite(): bool
	{
		return $this->isFavorite();
	}
}
