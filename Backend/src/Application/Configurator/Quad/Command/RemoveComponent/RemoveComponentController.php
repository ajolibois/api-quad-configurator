<?php

namespace App\Application\Configurator\Quad\Command\RemoveComponent;

use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Quad\Command\RemoveComponentToQuad\RemoveComponentToQuad;
use App\Domain\Configurator\Quad\Command\RemoveComponentToQuad\RemoveComponentToQuadHandler;
use App\Domain\Configurator\Quad\QuadId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class RemoveComponentController extends AbstractController
{
	/**
	 * RemoveComponentToQuadController constructor.
	 *
	 * @param RemoveComponentToQuadHandler $handler
	 */
	public function __construct(private RemoveComponentToQuadHandler $handler) { }

	/**
	 * @Route("/quad/remove-component", name="quad_remove_component", methods={"POST"})
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

			$componentType = new ComponentType($content->componentType);
			$pinCode = null;
			$quadId = new QuadId($content->quadId);
			$command = new RemoveComponentToQuad($quadId, $componentType, $pinCode);
			$presenter = new JsonRemoveComponentPresenter();
			$this->handler->handle($command, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
