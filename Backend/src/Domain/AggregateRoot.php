<?php

namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

abstract class AggregateRoot
{
	/**
	 * @var Event[]
	 */
	private array $events = [];

	/**
	 * @var \DateTimeInterface
	 *
	 * Creation date
	 *
	 * @ORM\Column(type="datetime_immutable")
	 */
	protected \DateTimeInterface $creationDate;

	/**
	 * @var \DateTimeInterface
	 *
	 * Update date
	 *
	 * @ORM\Column(type="datetime_immutable")
	 */
	protected \DateTimeInterface $updateDate;

	/**
	 * @param Event ...$events
	 * @return void
	 */
	protected function record(Event ...$events): void
	{
		foreach ($events as $event) {
			$this->events[] = $event;
		}
	}

	/**
	 * @return Event[]
	 */
	public function pullEvents(): array
	{
		$events = $this->events;
		$this->events = [];
		return $events;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function onAdd(): void
	{
		$this->creationDate = new \DateTimeImmutable('now');
	}

	/**
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 */
	public function onUpdate(): void
	{
		$this->updateDate = new \DateTimeImmutable('now');
	}
}
