<?php

namespace App\Domain\Configurator\Quad\Command\CreateQuad;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Presenter;

interface CreateQuadPresenter extends Presenter
{
	/**
	 * @param Quad $quad
	 */
	public function success(Quad $quad): void;

	/**
	 * @param string $message
	 */
	public function error(string $message): void;
}
