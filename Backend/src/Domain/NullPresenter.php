<?php

namespace App\Domain;

final class NullPresenter implements Presenter
{
	/**
	 * @return array
	 */
	public function present(): array
	{
		return [];
	}
}
