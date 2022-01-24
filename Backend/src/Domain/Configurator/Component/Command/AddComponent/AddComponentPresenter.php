<?php

namespace App\Domain\Configurator\Component\Command\AddComponent;

use App\Domain\Configurator\Component\Component;
use App\Domain\Presenter;

interface AddComponentPresenter extends Presenter
{
	/**
	 * @param string $message
	 */
	public function error(string $message): void;

	/**
	 * @param Component $component
	 */
	public function success(Component $component): void;
}
