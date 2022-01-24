<?php

namespace App\Domain\Configurator\Component;

use Doctrine\ORM\Mapping as ORM;

/** @Doctrine\ORM\Mapping\Embeddable */
final class ComponentId
{
	/**
	 *
	 * @var string
	 *
	 * @ORM\Id
	 * @ORM\Column(type="string", name="id")
	 */
	private string $id;

	/**
	 * QuadId constructor.
	 *
	 * @param string $id
	 */
	public function __construct(string $id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->id;
	}

	public function __toString(): string
	{
		return $this->id;
	}
}
