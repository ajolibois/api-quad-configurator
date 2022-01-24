<?php

namespace App\Domain\Configurator\Component\Command\UpdateComponent;

use App\Domain\Configurator\Component\Command\ComponentRepository;
use App\Domain\Command;
use App\Domain\CommandHandler;
use App\Domain\Presenter;

final class UpdateComponentHandler implements CommandHandler
{
	/**
	 * UpdateComponentHandler constructor.
	 *
	 * @param ComponentRepository $componentRepository
	 */
	public function __construct(private ComponentRepository $componentRepository) { }

	/**
	 * @param Command $command
	 * @param Presenter $presenter
	 */
	public function handle(Command $command, Presenter $presenter): void
	{
		if (!$command instanceof UpdateComponent) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof UpdateComponentPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			// TODO: OMG !!!! passer par l'aggregate....
			$component = $this->componentRepository->save($command->getComponent());
		} catch (\Exception $e) {
			$presenter->error('COMPONENT_NOT_UPDATED');
			return;
		}

		$presenter->success($component);
	}
}
