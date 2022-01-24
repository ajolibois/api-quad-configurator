<?php

namespace App\Domain\Configurator\Component\Query\GetCompatibleComponents;

use App\Domain\Configurator\Component\Component;
use App\Domain\Presenter;

interface GetCompatibleComponentsPresenter extends Presenter
{
	/**
	 * @param string $message
	 */
	public function error(string $message): void;

	/**
	 * @param Component ...$components
	 */
	public function success(Component ...$components): void;
}
