<?php

namespace App\Domain\Configurator\Quad;

use Doctrine\ORM\Mapping as ORM;

/** @Doctrine\ORM\Mapping\Embeddable */
final class PinCode
{
	/**
	 * @var ?int
	 *
	 * @ORM\Column(type="integer", name="pin_code", nullable=true, length=4)
	 */
	private ?int $pinCode = null;

	/**
	 * PinCode constructor.
	 * Must be 4 numeric chars.
	 *
	 * @param string $pinCode
	 */
	public function __construct(string $pinCode) {
		if (strlen($pinCode) !== 4) {
			throw new \InvalidArgumentException('PIN_MUST_HAVE_4_CHARS');
		}

		if (!is_int($pinCode)) {
			throw new \InvalidArgumentException('PIN_MUST_BE_NUMERIC_CHARS');
		}

		$this->pinCode = (int) $pinCode;
	}

	/**
	 * @return ?int
	 */
	public function getValue(): ?int
	{
		return $this->pinCode;
	}

	/**
	 * @param PinCode $pinCode
	 * @return bool
	 */
	public function isEqual(PinCode $pinCode): bool
	{
		return $this->pinCode === $pinCode->getValue();
	}
}
