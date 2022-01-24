<?php

namespace App\Infrastructure\Configurator\Repository;

use App\Domain\Configurator\Quad\Command\QuadNotFound;
use App\Domain\Configurator\Quad\Quad;
use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Configurator\Quad\Query\QuadRepository as QueryQuadRepository;
use App\Domain\Configurator\Quad\Command\QuadRepository as CommandQuadRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DQLQuadRepository implements CommandQuadRepository, QueryQuadRepository
{
	/**
	 * DQLQuadRepository constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(private EntityManagerInterface $entityManager) { }

	/**
	 * @param Quad $quad
	 */
	public function save(Quad $quad): void
	{
		$this->entityManager->persist($quad);
		$this->entityManager->flush();
	}

	/**
	 * @param QuadId $quadId
	 * @return Quad
	 * @throws QuadNotFound
	 */
	public function find(QuadId $quadId): Quad
	{
		$quad = $this->entityManager->find(Quad::class, $quadId);

		if (!$quad instanceof Quad) {
			throw new QuadNotFound();
		}

		return $quad;
	}

	/**
	 * @return Quad[]
	 */
	public function getAllList(): array
	{
		return $this->entityManager->getRepository(Quad::class)->findAll();
	}
}
