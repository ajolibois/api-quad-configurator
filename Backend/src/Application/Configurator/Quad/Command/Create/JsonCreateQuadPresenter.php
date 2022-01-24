<?php

namespace App\Application\Configurator\Quad\Command\Create;

use App\Domain\Configurator\Quad\Command\CreateQuad\CreateQuadPresenter;
use App\Domain\Configurator\Quad\Quad;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonCreateQuadPresenter implements CreateQuadPresenter
{
	/**
	 * @var Quad|null
	 */
	private ?Quad $quad = null;

	/**
	 * @var string|null
	 */
	private ?string $message = null;

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
			return new JsonResponse($this->message, 503);
		}

		if (!$this->quad) {
			return new JsonResponse(['INTERNAL_ERROR'], 500);
		}

		return new JsonResponse($this->quad->getId()->getValue(), 200);
	}
}
