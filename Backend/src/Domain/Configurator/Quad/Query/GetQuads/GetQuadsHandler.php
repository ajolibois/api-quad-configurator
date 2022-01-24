<?php

namespace App\Domain\Configurator\Quad\Query\GetQuads;

use App\Domain\Configurator\Quad\Query\QuadRepository;
use App\Domain\Presenter;
use App\Domain\Query;
use App\Domain\QueryHandler;

final class GetQuadsHandler implements QueryHandler
{
	/**
	 * GetQuadsHandler constructor.
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
		if (!$command instanceof GetQuads) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof GetQuadsPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$quads = $this->quadRepository->getAllList();
			foreach ($quads as $quad) {
				$quad->removePin();
			}
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('CANT_GET_QUADS');
			return;
		}

		$presenter->success(...$quads);
	}
}
