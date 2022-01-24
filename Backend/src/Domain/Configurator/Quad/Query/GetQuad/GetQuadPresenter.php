<?php

namespace App\Domain\Configurator\Quad\Query\GetQuad;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Presenter;

interface GetQuadPresenter extends Presenter
{
	/**
	 * @param string $message
	 */
	public function error(string $message): void;

	/**
	 * @param Quad $quad
	 */
	public function success(Quad $quad): void;
}
