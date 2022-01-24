<?php

namespace App\Domain;

interface QueryHandler
{
	/**
	 * @param Query $command
	 * @param Presenter $presenter
	 */
	public function handle(Query $command, Presenter $presenter): void;
}
