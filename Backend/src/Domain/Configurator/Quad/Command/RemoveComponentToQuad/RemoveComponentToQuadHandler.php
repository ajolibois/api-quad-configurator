<?php

namespace App\Domain\Configurator\Quad\Command\RemoveComponentToQuad;

use App\Domain\Command;
use App\Domain\CommandHandler;
use App\Domain\Configurator\Component\Command\ComponentRepository;
use App\Domain\Configurator\Quad\Command\QuadRepository;
use App\Domain\EventPublisher;
use App\Domain\Presenter;

final class RemoveComponentToQuadHandler implements CommandHandler
{
	/**
	 * CreateQuadHandler constructor.
	 *
	 * @param QuadRepository $quadRepository
	 * @param ComponentRepository $componentRepository
	 * @param EventPublisher $eventPublisher
	 */
	public function __construct(
		private QuadRepository $quadRepository,
		private ComponentRepository $componentRepository,
		private EventPublisher $eventPublisher
	) { }

	/**
	 * @param RemoveComponentToQuad $command
	 * @param RemoveComponentToQuadPresenter $presenter
	 */
	public function handle(Command $command, Presenter $presenter): void
	{
		if (!$command instanceof RemoveComponentToQuad) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof RemoveComponentToQuadPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$quad = $this->quadRepository->find($command->getQuadId());
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('CANT_FIND_QUAD');
			return;
		}

		if ($quad->isLocked()) {
			if (!$command->getPinCode()) {
				$presenter->error('QUAD_IS_LOCKED_BY_PIN');
				return;
			}

			if (!$quad->getPinCode()->isEqual($command->getPinCode())) {
				$presenter->error('WRONG_PIN_CODE');
				return;
			}
		}

		try {
			$quad->removeComponent($command->getComponentType());
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('COMPONENT_NOT_COMPATIBLE');
			return;
		}

		try {
			$this->quadRepository->save($quad);
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('CANT_ADD_COMPONENT');
			return;
		}

		$presenter->success($quad);

		$this->eventPublisher->publish(...$quad->pullEvents());
	}
}
