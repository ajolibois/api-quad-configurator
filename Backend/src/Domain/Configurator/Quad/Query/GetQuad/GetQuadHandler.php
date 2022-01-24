<?php

namespace App\Domain\Configurator\Quad\Query\GetQuad;

use App\Domain\Configurator\Quad\Query\QuadRepository;
use App\Domain\Presenter;
use App\Domain\Query;
use App\Domain\QueryHandler;

final class GetQuadHandler implements QueryHandler
{
	/**
	 * GetQuadHandler constructor.
	 *
	 * @param QuadRepository $quadRepository
	 */
	public function __construct(private QuadRepository $quadRepository) { }

	/**
	 * @param Query $command
	 * @param Presenter $presenter
	 */
	public function handle(Query $command, Presenter $presenter): void
	{
		if (!$command instanceof GetQuad) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof GetQuadPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$quad = $this->quadRepository->find($command->getQuadId());
			$quad->removePin();
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('QUAD_NOT_FOUND');
			return;
		}

		$presenter->success($quad);
	}
}
