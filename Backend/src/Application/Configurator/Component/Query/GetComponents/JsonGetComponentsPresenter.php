<?php

namespace App\Application\Configurator\Component\Query\GetComponents;

use App\Domain\Configurator\Component\Component;
use App\Domain\Configurator\Component\Query\GetComponents\GetComponentsPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonGetComponentsPresenter implements GetComponentsPresenter
{
	/**
	 * @var string|null
	 */
	private ?string $message = null;

	/**
	 * @var Component[]
	 */
	private array $components = [];

	/**
	 * @return mixed
	 */
	public function present(): mixed
	{
		if ($this->message) {
			return new JsonResponse([$this->message], 503);
		}

		if ($this->message) {
			return new JsonResponse([$this->message], 503);
		}

		return new JsonResponse([$this->components], 200);
	}

	/**
	 * @param string $message
	 */
	public function error(string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @param Component ...$components
	 */
	public function success(Component ...$components): void
	{
		$this->components = $components;
	}
}
