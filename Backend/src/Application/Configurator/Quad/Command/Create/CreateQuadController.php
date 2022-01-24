<?php

namespace App\Application\Configurator\Quad\Command\Create;

use App\Domain\Configurator\Quad\Command\CreateQuad\CreateQuad;
use App\Domain\Configurator\Quad\Command\CreateQuad\CreateQuadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CreateQuadController extends AbstractController
{
	/**
	 * CreateQuadController constructor.
	 *
	 * @param CreateQuadHandler $handler
	 */
	public function __construct(private CreateQuadHandler $handler) { }

	/**
	 * @Route("/quad/create", name="quad_create", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		$content = json_decode($request->getContent());

		try {
			$command = new CreateQuad($content->name);
			$presenter = new JsonCreateQuadPresenter();
			$this->handler->handle($command, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
