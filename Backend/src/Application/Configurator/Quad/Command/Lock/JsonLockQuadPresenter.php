<?php

namespace App\Application\Configurator\Quad\Command\Lock;

use App\Domain\Configurator\Quad\Command\LockQuad\LockQuadPresenter;
use App\Domain\Configurator\Quad\Quad;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonLockQuadPresenter implements LockQuadPresenter
{
	/**
	 * @var string|null
	 */
	private ?string $message = null;

	/**
	 * @var ?Quad
	 */
	private ?Quad $quad = null;

	/**
	 * @return JsonResponse
	 */
	public function present(): JsonResponse
	{
		if ($this->message) {
			return new JsonResponse($this->message, 503);
		}

		if (!$this->quad) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return new JsonResponse([$this->quad], 200);
	}

	/**
	 * @param string $message
	 */
	public function error(string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @param Quad $quad
	 */
	public function success(Quad $quad): void
	{
		$this->quad = $quad;
	}
}
