<?php

namespace App\Application\Configurator\Component\Query\GetComponent;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Component\Query\GetComponent\GetComponent;
use App\Domain\Configurator\Component\Query\GetComponent\GetComponentHandler;
use App\Domain\Configurator\Enum\ComponentType;
use App\Infrastructure\Configurator\Repository\DQLComponentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetComponentController extends AbstractController
{
	/**
	 * GetComponentController constructor.
	 *
	 * @param GetComponentHandler $handler
	 */
	public function __construct(private GetComponentHandler $handler) { }

	/**
	 * @Route("/component", name="get_component", methods={"GET"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		try {
			$componentId = new ComponentId($request->get('componentId'));
			$componentType = new ComponentType($request->get('componentType'));
			$query = new GetComponent($componentId, $componentType);
			$presenter = new JsonGetComponentPresenter();
			$this->handler->handle($query, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
