<?php

namespace App\Domain;

interface EventDispatcher
{
	/**
	 * @param Event $event
	 */
	public function dispatch(Event $event): void;
}
