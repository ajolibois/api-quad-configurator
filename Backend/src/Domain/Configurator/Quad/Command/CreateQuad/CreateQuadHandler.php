<?php

namespace App\Domain\Configurator\Quad\Command\CreateQuad;

use App\Domain\Command;
use App\Domain\CommandHandler;
use App\Domain\Configurator\Quad\Quad;
use App\Domain\Configurator\Quad\QuadIdGenerator;
use App\Domain\EventPublisher;
use App\Domain\Presenter;
use App\Domain\Configurator\Quad\Command\QuadRepository;

final class CreateQuadHandler implements CommandHandler
{
	/**
	 * CreateQuadHandler constructor.
	 *
	 * @param QuadRepository $quadRepository
	 * @param QuadIdGenerator $quadIdGenerator
	 * @param EventPublisher $eventPublisher
	 */
	public function __construct(
		private QuadRepository $quadRepository,
		private QuadIdGenerator $quadIdGenerator,
		private EventPublisher $eventPublisher
	) { }

	/**
	 * @param CreateQuad $command
	 * @param CreateQuadPresenter $presenter
	 */
	public function handle(Command $command, Presenter $presenter): void
	{
		if (!$command instanceof CreateQuad) {
			throw new \InvalidArgumentException('BAD_COMMAND', 500);
		}

		if (!$presenter instanceof CreateQuadPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER', 500);
		}

		try {
			$quad = Quad::createNew($command->getName(), $this->quadIdGenerator);
			$this->quadRepository->save($quad);
		} catch (\Exception $e) {
			$presenter->error("CANT_SAVE_QUAD");
			return;
		}

		$presenter->success($quad);

		$this->eventPublisher->publish(...$quad->pullEvents());
	}
}
