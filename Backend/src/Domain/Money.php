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
	public static function createNull(Currency $currency)
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
	 * @return bool
	 */
	public function isNull()
	{
		return bccomp($this->amount, '0', self::DECIMAL_SCALE) === 0;
	}

	/**
	 * @param Money $a
	 * @param Money $b
	 * @return Money
	 */
	public static function min(Money $a, Money $b)
	{
		self::assertSameCurrency($a, $b);
		return bccomp($a->getAmount(), $b->getAmount(), self::DECIMAL_SCALE) === -1 ? clone $a : clone $b;
	}

	/**
	 * @param Money $a
	 * @param Money $b
	 * @return Money
	 */
	public static function max(Money $a, Money $b)
	{
		self::assertSameCurrency($a, $b);
		return bccomp($a->getAmount(), $b->getAmount(), self::DECIMAL_SCALE) === -1 ? clone $b : clone $a;
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
	 * @return float|string
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @return Currency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @param Money $money
	 * @return Money
	 */
	public function add(Money $money)
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
	public function sub(Money $money)
	{
		self::assertSameCurrency($money, $this);

		return new self(
			bcsub($this->amount, $money->getAmount(), self::DECIMAL_SCALE),
			$this->getCurrency()
		);
	}

	/**
	 * @return Money
	 */
	public function abs()
	{
		if ($this->isPositiveOrNull()) {
			return clone $this;
		}

		return $this->negate();
	}

	/**
	 * @param Money $money
	 * @return bool
	 */
	public function hasSameCurrency(Money $money)
	{
		return $money->getCurrency()->equals($this->getCurrency());
	}

	/**
	 * @return Money
	 */
	public function negate()
	{
		return new self(
			bcmul('-1', $this->amount, self::DECIMAL_SCALE),
			$this->currency
		);
	}

	/**
	 * @return bool
	 */
	public function isPositive():bool
	{
		return bccomp($this->amount, '0', self::DECIMAL_SCALE) > 0;
	}

	/**
	 * @return bool
	 */
	public function isPositiveOrNull()
	{
		return $this->isPositive() || $this->isNull();
	}

	/**
	 * @return bool
	 */
	public function isNegative()
	{
		return bccomp($this->amount, '0', self::DECIMAL_SCALE) < 0;
	}

	/**
	 * @return bool
	 */
	public function isNegativeOrNull()
	{
		return $this->isNegative() || $this->isNull();
	}

	/**
	 * @param Money $other
	 * @return bool
	 */
	public function isGreaterThan(Money $other)
	{
		return bccomp($this->amount, $other->amount, self::DECIMAL_SCALE) > 0;
	}

	/**
	 * @param Money $other
	 * @return bool
	 */
	public function isGreaterThanOrEqual(Money $other)
	{
		return bccomp($this->amount, $other->amount, self::DECIMAL_SCALE) >= 0;
	}

	/**
	 * @param Money $other
	 * @return bool
	 */
	public function isLessThan(Money $other)
	{
		return bccomp($this->amount, $other->amount, self::DECIMAL_SCALE) < 0;
	}

	/**
	 * @param Money $other
	 * @return bool
	 */
	public function isLessThanOrEqual(Money $other)
	{
		return bccomp($this->amount, $other->amount, self::DECIMAL_SCALE) <= 0;
	}

	/**
	 * @param Money $other
	 * @return bool
	 */
	public function isEqual(Money $other): bool
	{
		return bccomp($this->amount, $other->amount, self::DECIMAL_SCALE) == 0 && $this->hasSameCurrency($other);
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
	private function getPrecisionMultiplier()
	{
		return str_pad(
			'1.',
			strlen('1.') + self::DECIMAL_SCALE,
			'0'
		);
	}
}
