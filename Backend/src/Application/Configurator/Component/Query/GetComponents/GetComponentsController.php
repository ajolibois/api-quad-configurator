<?php

namespace App\Application\Configurator\Component\Query\GetComponents;

use App\Domain\Configurator\Component\Query\GetComponents\GetComponents;
use App\Domain\Configurator\Component\Query\GetComponents\GetComponentsHandler;
use App\Domain\Configurator\Enum\ComponentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetComponentsController extends AbstractController
{
	/**
	 * GetComponentsController constructor.
	 *
	 * @param GetComponentsHandler $handler
	 */
	public function __construct(private GetComponentsHandler $handler) { }

	/**
	 * @Route("/components", name="get_components", methods={"GET"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		try {
			$componentType = new ComponentType($request->get('componentType'));
			$query = new GetComponents($componentType);
			$presenter = new JsonGetComponentsPresenter();
			$this->handler->handle($query, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
