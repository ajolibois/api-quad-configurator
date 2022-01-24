<?php

namespace App\Domain\Configurator\Quad;

use Doctrine\ORM\Mapping as ORM;

/** @Doctrine\ORM\Mapping\Embeddable */
final class QuadId
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
}
