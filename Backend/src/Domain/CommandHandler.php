<?php

namespace App\Domain;

interface CommandHandler
{
	/**
	 * @param Command $command
	 * @param Presenter $presenter
	 */
	public function handle(Command $command, Presenter $presenter): void;
}
