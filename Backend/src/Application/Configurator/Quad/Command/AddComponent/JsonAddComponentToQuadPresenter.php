<?php

namespace App\Application\Configurator\Quad\Command\AddComponent;

use App\Domain\Configurator\Component\Component;
use App\Domain\Configurator\Quad\Command\AddComponentToQuad\AddComponentToQuadPresenter;
use App\Domain\Configurator\Quad\Quad;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonAddComponentToQuadPresenter implements AddComponentToQuadPresenter
{
	/**
	 * @var ?Component
	 */
	private ?Component $notCompatibleComponent = null;

	/**
	 * @var ?Quad
	 */
	private ?Quad $quad = null;

	/**
	 * @var ?string
	 */
	private ?string $message = null;

	/**
	 * @param Component $component
	 */
	public function componentNotCompatible(Component $component): void
	{
		$this->notCompatibleComponent = $component;
	}

	/**
	 * @param Quad $quad
	 */
	public function success(Quad $quad): void
	{
		$this->quad = $quad;
	}

	/**
	 * @param string $message
	 */
	public function error(string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @return mixed
	 */
	public function present(): JsonResponse
	{
		if ($this->message) {
			return new JsonResponse($this->message, 403);
		}

		if ($this->notCompatibleComponent) {
			return new JsonResponse([$this->notCompatibleComponent], 403);
		}

		if (!$this->quad) {
			return new JsonResponse(['INTERNAL_ERROR'], 500);
		}

		return new JsonResponse($this->quad, 200);
	}
}
