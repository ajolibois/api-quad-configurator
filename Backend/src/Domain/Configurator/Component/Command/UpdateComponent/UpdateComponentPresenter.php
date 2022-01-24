<?php

namespace App\Domain\Configurator\Component\Command\UpdateComponent;

use App\Domain\Configurator\Component\Component;
use App\Domain\Presenter;

interface UpdateComponentPresenter extends Presenter
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
