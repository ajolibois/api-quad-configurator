<?php

namespace App\Application\Configurator\Quad\Query\GetCompatibleComponents;

use App\Domain\Configurator\Component\Query\GetCompatibleComponents\GetCompatibleComponentsHandler;
use App\Domain\Configurator\Component\Query\GetCompatibleComponents\GetCompatibleComponents;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Quad\QuadId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetCompatibleComponentsController extends AbstractController
{
	/**
	 * GetCompatibleComponentsController constructor.
	 *
	 * @param GetCompatibleComponentsHandler $handler
	 */
	public function __construct(private GetCompatibleComponentsHandler $handler) { }

	/**
	 * @Route("/quad/get-compatible-components", name="get_compatible_components", methods={"GET"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		try {
			$componentType = new ComponentType($request->get('componentType'));
			$pinCode = null;
			$quadId = new QuadId($request->get('quadId'));
			$query = new GetCompatibleComponents($quadId, $componentType);
			$presenter = new JsonGetCompatibleComponentsPresenter();
			$this->handler->handle($query, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
