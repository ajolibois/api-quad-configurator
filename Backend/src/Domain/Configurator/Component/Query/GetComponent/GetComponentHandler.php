<?php

namespace App\Domain\Configurator\Component\Query\GetComponent;

use App\Domain\Configurator\Component\Query\ComponentRepository;
use App\Domain\Presenter;
use App\Domain\Query;
use App\Domain\QueryHandler;

final class GetComponentHandler implements QueryHandler
{
	/**
	 * GetComponentHandler constructor.
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
		if (!$command instanceof GetComponent) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof GetComponentPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$component = $this->componentRepository->find($command->getComponentId(), $command->getComponentType());
		} catch (\Exception $e) {
			$presenter->error('COMPONENT_NOT_FOUND');
			return;
		}

		$presenter->success($component);
	}
}
