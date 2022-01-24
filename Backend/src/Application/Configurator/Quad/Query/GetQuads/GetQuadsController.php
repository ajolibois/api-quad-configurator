<?php

namespace App\Application\Configurator\Quad\Query\GetQuads;

use App\Domain\Configurator\Quad\Query\GetQuads\GetQuads;
use App\Domain\Configurator\Quad\Query\GetQuads\GetQuadsHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetQuadsController
{
	/**
	 * GetQuadsController constructor.
	 *
	 * @param GetQuadsHandler $handler
	 */
	public function __construct(private GetQuadsHandler $handler) { }

	/**
	 * @Route("/quads", name="quads_get", methods={"GET"})
	 * @return JsonResponse
	 */
	public function get(): JsonResponse
	{
		try {
			$query = new GetQuads();
			$presenter = new JsonGetQuadsPresenter();
			$this->handler->handle($query, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
