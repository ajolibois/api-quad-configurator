<?php

namespace App\Application\Configurator\Quad\Command\RemoveComponent;

use App\Domain\Configurator\Quad\Command\RemoveComponentToQuad\RemoveComponentToQuadPresenter;
use App\Domain\Configurator\Quad\Quad;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonRemoveComponentPresenter implements RemoveComponentToQuadPresenter
{
	/**
	 * @var ?Quad
	 */
	private ?Quad $quad = null;

	/**
	 * @var ?string
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
	 * @return JsonResponse
	 */
	public function present(): JsonResponse
	{
		if ($this->message) {
			return new JsonResponse($this->message, 403);
		}

		if (!$this->quad) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return new JsonResponse([], 200);
	}
}
