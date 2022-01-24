<?php

namespace App\Domain\Configurator\Quad\Command\LockQuad;

use App\Domain\Command;
use App\Domain\CommandHandler;
use App\Domain\EventPublisher;
use App\Domain\Presenter;
use App\Domain\Configurator\Quad\Command\CantSaveQuad;
use App\Domain\Configurator\Quad\Command\QuadNotFound;
use App\Domain\Configurator\Quad\Command\QuadRepository;

final class LockQuadHandler implements CommandHandler
{
	/**
	 * ValidateQuadHandler constructor.
	 *
	 * @param QuadRepository $quadRepository
	 * @param EventPublisher $eventPublisher
	 */
	public function __construct(
		private QuadRepository $quadRepository,
		private EventPublisher $eventPublisher
	) { }

	/**
	 * @param Command $command
	 * @param Presenter $presenter
	 */
	public function handle(Command $command, Presenter $presenter): void
	{
		if (!$command instanceof LockQuad) {
			throw new \InvalidArgumentException('BAD_COMMAND');
		}

		if (!$presenter instanceof LockQuadPresenter) {
			throw new \InvalidArgumentException('BAD_PRESENTER');
		}

		try {
			$quad = $this->quadRepository->find($command->getQuadId());

			if ($quad->isLocked()) {
				$presenter->error('QUAD_ALREADY_LOCKED');
				return;
			}

			$quad = $quad->lock($command->getPinCode());
			$this->quadRepository->save($quad);
		} catch (QuadNotFound $e) {
			// TODO: Log error
			$presenter->error('QUAD_NOT_FOUND');
			return;
		} catch (CantSaveQuad $e) {
			// TODO: Log error
			$presenter->error('CANT_SAVE_QUAD');
			return;
		} catch (\Exception $e) {
			// TODO: Log error
			$presenter->error('CANT_LOCK_QUAD');
			return;
		}

		$presenter->success($quad);

		$this->eventPublisher->publish(...$quad->pullEvents());
	}
}
