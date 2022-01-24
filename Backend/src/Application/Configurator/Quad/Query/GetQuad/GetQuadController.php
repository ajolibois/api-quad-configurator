<?php

namespace App\Application\Configurator\Quad\Query\GetQuad;

use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Configurator\Quad\Query\GetQuad\GetQuad;
use App\Domain\Configurator\Quad\Query\GetQuad\GetQuadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetQuadController extends AbstractController
{
	/**
	 * GetQuadController constructor.
	 *
	 * @param GetQuadHandler $handler
	 */
	public function __construct(private GetQuadHandler $handler) { }

	/**
	 * @Route("/quad", name="quad_get", methods={"GET"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		try {
			$quadId = new QuadId($request->get('quadId'));
			$query = new GetQuad($quadId);
			$presenter = new JsonGetQuadPresenter();
			$this->handler->handle($query, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
