<?php

namespace App\Application\Configurator\Component\Command\Update;

use App\Domain\Configurator\Component\Command\UpdateComponent\UpdateComponentPresenter;
use App\Domain\Configurator\Component\Component;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonUpdateComponentPresenter implements UpdateComponentPresenter
{
	/**
	 * @var string|null
	 */
	private ?string $message = null;

	/**
	 * @var ?Component
	 */
	private ?Component $component = null;

	/**
	 * @return mixed
	 */
	public function present(): mixed
	{
		if ($this->message) {
			return new JsonResponse([$this->message], 503);
		}

		if (!$this->component) {
			return new JsonResponse(['INTERNAL_ERROR'], 500);
		}

		return new JsonResponse([$this->component], 200);
	}

	/**
	 * @param string $message
	 */
	public function error(string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @param Component $component
	 */
	public function success(Component $component): void
	{
		$this->component = $component;
	}
}
