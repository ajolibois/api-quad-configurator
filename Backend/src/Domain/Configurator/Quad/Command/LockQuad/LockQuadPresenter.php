<?php

namespace App\Domain\Configurator\Quad\Command\LockQuad;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Presenter;

interface LockQuadPresenter extends Presenter
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
