<?php

namespace App\Infrastructure;

use App\Domain\Event;
use App\Domain\EventPublisher;
use App\Infrastructure\Configurator\PhpConfiguratorEventDispatcher;

final class PhpEventPublisher implements EventPublisher
{
	public function publish(Event ...$events): void
	{
		$publishers = [
			new PhpConfiguratorEventDispatcher()
		];

		foreach ($events as $event) {
			foreach ($publishers as $publisher) {
				$publisher->dispatch($event);
			}
		}
	}
}
