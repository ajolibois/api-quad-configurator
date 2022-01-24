<?php

namespace App\Domain;

interface EventPublisher
{
	/**
	 * @param Event ...$events
	 */
	public function publish(Event ...$events): void;
}
