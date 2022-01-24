<?php

namespace App\Application\Configurator\Quad\Command\Lock;

use App\Domain\Configurator\Quad\Command\LockQuad\LockQuad;
use App\Domain\Configurator\Quad\Command\LockQuad\LockQuadHandler;
use App\Domain\Configurator\Quad\PinCode;
use App\Domain\Configurator\Quad\QuadId;
use App\Infrastructure\Configurator\Repository\DQLQuadRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class LockQuadController
{
	/**
	 * LockQuadController constructor.
	 *
	 * @param LockQuadHandler $handler
	 */
	public function __construct(private LockQuadHandler $handler) { }

	/**
	 * @Route("/quad/lock", name="quad_lock", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		$content = json_decode($request->getContent());

		try {
			$quadId = new QuadId($content->quadId);
			$pinCode = new PinCode($content->pinCode);
			$command = new LockQuad($quadId, $pinCode);
			$presenter = new JsonLockQuadPresenter();
			$this->handler->handle($command, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse('INTERNAL_ERROR', 500);
		}

		return $presenter->present();
	}
}
