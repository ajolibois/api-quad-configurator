<?php

namespace App\Domain;

interface Policy
{
	/**
	 * @param Event $event
	 */
	public function on(Event $event): void;
}
