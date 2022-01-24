<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Money;

interface Component
{
    /**
     * @return ComponentId|null
     */
    public function getId(): ?ComponentId;

    /**
     * @param Component $component
     * @return bool
     */
    public function isCompatibleComponent(Component $component): bool;

	/**
	 * @return ComponentType
	 */
	public function getType(): ComponentType;

	/**
	 * @return Money
	 */
	public function getPrice(): Money;

	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @return string
	 */
	public function getImgUrl(): string;

	/**
	 * @return string
	 */
	public function getTags(): string;

	/**
	 * @return bool
	 */
	public function isFavorite(): bool;

	/**
	 * @return string
	 */
	public function getDescription(): string;
}
