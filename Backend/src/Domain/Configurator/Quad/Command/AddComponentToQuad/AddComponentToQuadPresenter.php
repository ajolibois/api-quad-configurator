<?php

namespace App\Domain\Configurator\Quad\Command\AddComponentToQuad;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Presenter;

interface AddComponentToQuadPresenter extends Presenter
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
