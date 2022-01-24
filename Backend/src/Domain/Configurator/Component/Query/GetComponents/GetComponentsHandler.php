<?php

namespace App\Domain\Configurator\Component\Query\GetComponents;

use App\Domain\Configurator\Component\Query\ComponentRepository;
use App\Domain\Presenter;
use App\Domain\Query;
use App\Domain\QueryHandler;

final class GetComponentsHandler implements QueryHandler
{
	/**
	 * GetComponentsHandler constructor.
	 *
	 * @param ComponentRepository $componentRepository
	 */
	public function __construct(private ComponentRepository $componentRepository) { }

	/**
	 * @param Query $command
	 * @param Presenter $presenter
	 */
	public function handle(Query $command, Presenter $presenter): void
	{
		if (!$command instanceof GetComponents) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof GetComponentsPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$components = $this->componentRepository->getList($command->getComponentType());
		} catch (\Exception $e) {
			$presenter->error('CANT_GET_COMPONENTS');
			return;
		}

		$presenter->success(...$components);
	}
}
