<?php

namespace App\Infrastructure\Configurator;

use App\Domain\Event;
use App\Domain\EventDispatcher;

final class PhpConfiguratorEventDispatcher implements EventDispatcher
{
	public function dispatch(Event $event): void
	{
		// TODO: Implement dispatch() method.
	}
}
