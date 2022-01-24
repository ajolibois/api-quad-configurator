<?php

namespace App\Domain\Configurator\Quad\Command\AddComponentToQuad;

use App\Domain\Command;
use App\Domain\CommandHandler;
use App\Domain\Configurator\Component\Command\ComponentRepository;
use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\EventPublisher;
use App\Domain\Presenter;
use App\Domain\Configurator\Quad\Command\QuadRepository;

final class AddComponentToQuadHandler implements CommandHandler
{
	/**
	 * CreateQuadHandler constructor.
	 *
	 * @param QuadRepository $quadRepository
	 * @param ComponentRepository $componentRepository
	 * @param EventPublisher $eventPublisher
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		private QuadRepository $quadRepository,
		private ComponentRepository $componentRepository,
		private EventPublisher $eventPublisher,
		private ComponentDiscriminator $componentDiscriminator
	) { }

	/**
	 * @param AddComponentToQuad $command
	 * @param AddComponentToQuadPresenter $presenter
	 */
	public function handle(Command $command, Presenter $presenter): void
	{
		if (!$command instanceof AddComponentToQuad) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof AddComponentToQuadPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$quad = $this->quadRepository->find($command->getQuadId());
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('CANT_FIND_QUAD');
			return;
		}

		$componentType = $this->componentDiscriminator->getComponentTypeByComponentId($command->getComponentId());
		if (!$componentType) {
			$presenter->error('INVALID_COMPONENT_ID');
			return;
		}

		try {
			$component = $this->componentRepository->find($command->getComponentId(), $componentType);
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('CANT_FIND_COMPONENT');
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
			$quad->addComponent($component);
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
