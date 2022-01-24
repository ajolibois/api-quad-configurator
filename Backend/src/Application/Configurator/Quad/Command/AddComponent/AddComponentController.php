<?php

namespace App\Application\Configurator\Quad\Command\AddComponent;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Quad\Command\AddComponentToQuad\AddComponentToQuad;
use App\Domain\Configurator\Quad\Command\AddComponentToQuad\AddComponentToQuadHandler;
use App\Domain\Configurator\Quad\QuadId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

final class AddComponentController extends AbstractController
{
	/**
	 * AddComponentController constructor.
	 *
	 * @param AddComponentToQuadHandler $handler
	 */
	public function __construct(private AddComponentToQuadHandler $handler) { }

	/**
	 * @Route("/quad/add-component", name="quad_add_component", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		try {
			$content = json_decode($request->getContent());

			// Si le quad est lock récup le code pin en session
			// sinon dans la requete
			// Le domaine se charge de renvoyer un message d'erreur et le front demandera le pin

			$pinCode = null;
			$quadId = new QuadId($content->quadId);
			$componentId = new ComponentId($content->componentId);
			$command = new AddComponentToQuad($quadId, $componentId, $pinCode);
			$presenter = new JsonAddComponentToQuadPresenter();
			$this->handler->handle($command, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
