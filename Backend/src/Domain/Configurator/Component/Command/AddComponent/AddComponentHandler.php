<?php

namespace App\Domain\Configurator\Component\Command\AddComponent;

use App\Domain\AggregateRoot;
use App\Domain\Configurator\Component\Command\ComponentRepository;
use App\Domain\Command;
use App\Domain\CommandHandler;
use App\Domain\Configurator\Component\BaseComponent;
use App\Domain\Configurator\Component\Service\ComponentIdGenerator;
use App\Domain\EventPublisher;
use App\Domain\Presenter;

final class AddComponentHandler implements CommandHandler
{
	/**
	 * AddComponentHandler constructor.
	 *
	 * @param ComponentRepository $componentRepository
	 * @param ComponentIdGenerator $componentIdGenerator
	 * @param EventPublisher $eventPublisher
	 */
	public function __construct(
		private ComponentRepository $componentRepository,
		private ComponentIdGenerator $componentIdGenerator,
		private EventPublisher $eventPublisher
	) { }

	/**
	 * @param Command $command
	 * @param Presenter $presenter
	 */
	public function handle(Command $command, Presenter $presenter): void
	{
		if (!$command instanceof AddComponent) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof AddComponentPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		$component = $command->getComponent();

		if (!$component instanceof AggregateRoot) {
			throw new \InvalidArgumentException('COMPONENT_MUST_BE_AN_AGGREGATE_ROOT');
		}

		if (!$component instanceof BaseComponent) {
			throw new \LogicException('COMPONENT_MUST_BE_INSTANCE_OF_ABSTRACT_COMPONENT');
		}

		try {
			$component->addNew($this->componentIdGenerator);
		} catch (\Exception $e) {
			$presenter->error('INTERNAL_ERROR');
			return;
		}

		try {
			$this->componentRepository->save($command->getComponent());
		} catch (\Exception $e) {
			$presenter->error('COMPONENT_NOT_CREATED');
			return;
		}

		$presenter->success($component);

		$this->eventPublisher->publish(...$component->pullEvents());
	}
}
