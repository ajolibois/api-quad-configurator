<?php

namespace App\Application\Configurator\Component\Command\Add;

use App\Domain\Configurator\Component\Command\AddComponent\AddComponentPresenter;
use App\Domain\Configurator\Component\Component;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonAddComponentPresenter implements AddComponentPresenter
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
	 * @return JsonResponse
	 */
	public function present(): JsonResponse
	{
		if ($this->message) {
			return new JsonResponse([$this->message], 503);
		}

		if (!$this->component) {
			return new JsonResponse(['INTERNAL_ERROR'], 500);
		}

		return new JsonResponse(["componentId" => $this->component->getId()->getValue()], 200);
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
