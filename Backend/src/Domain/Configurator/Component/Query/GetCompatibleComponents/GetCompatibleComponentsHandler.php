<?php

namespace App\Domain\Configurator\Component\Query\GetCompatibleComponents;

use App\Domain\Configurator\Component\Query\ComponentRepository;
use App\Domain\Configurator\Quad\Query\QuadRepository;
use App\Domain\Presenter;
use App\Domain\Query;
use App\Domain\QueryHandler;

final class GetCompatibleComponentsHandler implements QueryHandler
{
	/**
	 * GetCompatibleComponentsHandler constructor.
	 *
	 * @param ComponentRepository $componentRepository
	 * @param QuadRepository $quadRepository
	 */
	public function __construct(
		private ComponentRepository $componentRepository,
		private QuadRepository $quadRepository
	) { }

	/**
	 * @param Query $command
	 * @param Presenter $presenter
	 */
	public function handle(Query $command, Presenter $presenter): void
	{
		if (!$command instanceof GetCompatibleComponents) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof GetCompatibleComponentsPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$quad = $this->quadRepository->find($command->getQuadId());
		} catch (\Exception $e) {
			$presenter->error('QUAD_NOT_FOUND');
			return;
		}

		try {
			$compatibleComponents = $this->componentRepository->getCompatibleComponents(
				$quad,
				$command->getComponentType()
			);
		} catch (\Exception $e) {
			$presenter->error('CANT_GET_COMPONENTS');
			return;
		}

		$presenter->success(...$compatibleComponents);
	}
}
