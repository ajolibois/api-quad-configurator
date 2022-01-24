<?php

namespace App\Domain\Configurator\Quad\Query\GetQuads;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Presenter;

interface GetQuadsPresenter extends Presenter
{
	/**
	 * @param string $message
	 */
	public function error(string $message): void;

	/**
	 * @param Quad ...$quads
	 */
	public function success(Quad ...$quads): void;
}
