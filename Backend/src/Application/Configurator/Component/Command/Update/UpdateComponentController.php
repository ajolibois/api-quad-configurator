<?php

namespace App\Application\Configurator\Component\Command\Update;

use App\Domain\Configurator\Component\Command\UpdateComponent\UpdateComponent;
use App\Domain\Configurator\Component\Command\UpdateComponent\UpdateComponentHandler;
use App\Domain\Configurator\Component\Motor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class UpdateComponentController extends AbstractController
{
	/**
	 * UpdateComponentController constructor.
	 *
	 * @param UpdateComponentHandler $handler
	 */
	public function __construct(private UpdateComponentHandler $handler) { }

	/**
	 * @Route("/component/update", name="update_component")
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		try {
			$component = new Motor(
				'name',
			);

			$command = new UpdateComponent($component);
			$presenter = new JsonUpdateComponentPresenter();
			$this->handler->handle($command, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
