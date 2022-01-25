<?php

namespace App\Domain;

use InvalidArgumentException;

final class Money
{
	private float $amount;
	private Currency $currency;

	public const DECIMAL_SCALE = 2;
	private const CURRENCY_CHARS = 3;

	public function __construct(float $amount, Currency $currency)
	{
		$this->amount = bcmul(
			$amount,
			$this->getPrecisionMultiplier(),
			self::DECIMAL_SCALE
		);

		$this->currency = $currency;
	}

	/**
	 * @param Currency $currency
	 * @return Money
	 */
	public static function createNull(Currency $currency): self
	{
		return new self(0, $currency);
	}

	/**
	 * Format : 12456.78EUR
	 *
	 * @param string $amountCurrency
	 * @return Money
	 */
	public static function createFromString(string $amountCurrency): self
	{
		$currency = substr($amountCurrency, -self::CURRENCY_CHARS);

		if (!Currency::isValid($currency)) {
			throw new InvalidArgumentException(
				sprintf('Currency %s is invalid for given %s', $currency, $amountCurrency)
			);
		}

		return new self((float) $amountCurrency, new Currency($currency));
	}

	/**
	 * @param Money $a
	 * @param Money $b
	 */
	private static function assertSameCurrency(Money $a, Money $b)
	{
		if (!$a->hasSameCurrency($b)) {
			throw new InvalidArgumentException('Can\'t compare moneys with different currencies');
		}
	}

	/**
	 * @return float
	 */
	public function getAmount(): float
	{
		return $this->amount;
	}

	/**
	 * @return Currency
	 */
	public function getCurrency(): Currency
	{
		return $this->currency;
	}

	/**
	 * @param Money $money
	 * @return Money
	 */
	public function add(Money $money): self
	{
		self::assertSameCurrency($money, $this);

		return new self(
			bcadd($this->amount, $money->getAmount(), self::DECIMAL_SCALE),
			$this->getCurrency()
		);
	}

	/**
	 * @param Money $money
	 * @return Money
	 */
	public function sub(Money $money): self
	{
		self::assertSameCurrency($money, $this);

		return new self(
			bcsub($this->amount, $money->getAmount(), self::DECIMAL_SCALE),
			$this->getCurrency()
		);
	}

	/**
	 * @param Money $money
	 * @return bool
	 */
	public function hasSameCurrency(Money $money): bool
	{
		return $money->getCurrency()->equals($this->getCurrency());
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->amount . $this->currency;
	}

	/**
	 * @return string
	 */
	private function getPrecisionMultiplier(): string
	{
		return str_pad(
			'1.',
			strlen('1.') + self::DECIMAL_SCALE,
			'0'
		);
	}
}
