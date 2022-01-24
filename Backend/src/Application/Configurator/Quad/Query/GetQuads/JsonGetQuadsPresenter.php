<?php

namespace App\Application\Configurator\Quad\Query\GetQuads;

use App\Domain\Configurator\Quad\Quad;
use App\Domain\Configurator\Quad\Query\GetQuads\GetQuadsPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonGetQuadsPresenter implements GetQuadsPresenter
{
	/**
	 * @var string|null
	 */
	private ?string $message = null;

	/**
	 * @var Quad[]
	 */
	private array $quads = [];

	/**
	 * @return JsonResponse
	 */
	public function present(): JsonResponse
	{
		if ($this->message) {
			return new JsonResponse($this->message, 503);
		}

		return new JsonResponse($this->quads, 200);
	}

	/**
	 * @param string $message
	 */
	public function error(string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @param Quad ...$quads
	 */
	public function success(Quad ...$quads): void
	{
		$this->quads = $quads;
	}
}
