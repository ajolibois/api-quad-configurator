<?php

namespace App\Infrastructure\Configurator\Repository;

use App\Domain\Configurator\Component\Battery;
use App\Domain\Configurator\Component\Camera;
use App\Domain\Configurator\Component\Command\ComponentRepository as CommandComponentRepository;
use App\Domain\Configurator\Component\Component;
use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Component\Frame;
use App\Domain\Configurator\Component\Motor;
use App\Domain\Configurator\Component\Propeller;
use App\Domain\Configurator\Component\Query\ComponentRepository as QueryComponentRepository;
use App\Domain\Configurator\Component\Receptor;
use App\Domain\Configurator\Component\Stack;
use App\Domain\Configurator\Component\Vtx;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Quad\Quad;
use Doctrine\ORM\EntityManagerInterface;

final class DQLComponentRepository implements CommandComponentRepository, QueryComponentRepository
{
	/**
	 * DQLQuadRepository constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(private EntityManagerInterface $entityManager) { }

	/**
	 * @param Component $component
	 */
	public function save(Component $component): void
	{
		$this->entityManager->persist($component);
		$this->entityManager->flush();
	}

	/**
	 * @param Quad $quad
	 * @param ComponentType $componentType
	 * @return array
	 */
	public function getCompatibleComponents(Quad $quad, ComponentType $componentType): array
	{
		$components = [];
		switch ($componentType) {
			case ComponentType::MOTOR():
				$components = $this->entityManager->getRepository(Motor::class)->findAll();
				break;
			case ComponentType::VTX():
				$components = $this->entityManager->getRepository(Vtx::class)->findAll();
				break;
			case ComponentType::STACK():
				$components = $this->entityManager->getRepository(Stack::class)->findAll();
				break;
			case ComponentType::RECEPTOR():
				$components = $this->entityManager->getRepository(Receptor::class)->findAll();
				break;
			case ComponentType::PROPELLER():
				$components = $this->entityManager->getRepository(Propeller::class)->findAll();
				break;
			case ComponentType::FRAME():
				$components = $this->entityManager->getRepository(Frame::class)->findAll();
				break;
			case ComponentType::CAMERA():
				$components = $this->entityManager->getRepository(Camera::class)->findAll();
				break;
			case ComponentType::BATTERY():
				$components = $this->entityManager->getRepository(Battery::class)->findAll();
				break;
			default:
				return $components;
		}

		$compatibleComponents = [];

		foreach ($components as $component) {
			if (!$component instanceof Component) {
				continue;
			}

			if ($quad->isCompatibleComponent($component)) {
				$compatibleComponents[] = $component;
			}
		}

		return $compatibleComponents;
	}

	/**
	 * @param ComponentId $componentId
	 * @param ComponentType $componentType
	 * @return Component
	 */
	public function find(ComponentId $componentId, ComponentType $componentType): Component
	{
		switch ($componentType) {
			case ComponentType::MOTOR():
				$component = $this->entityManager->find(Motor::class, $componentId);
				break;
			case ComponentType::VTX():
				$component = $this->entityManager->find(Vtx::class, $componentId);
				break;
			case ComponentType::STACK():
				$component = $this->entityManager->find(Stack::class, $componentId);
				break;
			case ComponentType::RECEPTOR():
				$component = $this->entityManager->find(Receptor::class, $componentId);
				break;
			case ComponentType::PROPELLER():
				$component = $this->entityManager->find(Propeller::class, $componentId);
				break;
			case ComponentType::FRAME():
				$component = $this->entityManager->find(Frame::class, $componentId);
				break;
			case ComponentType::CAMERA():
				$component = $this->entityManager->find(Camera::class, $componentId);
				break;
			case ComponentType::BATTERY():
				$component = $this->entityManager->find(Battery::class, $componentId);
				break;
			default:
				throw new ComponentNotFound(sprintf(
					"Component %s #%s not found",
					$componentType->getValue(),
					$componentId->getValue(),
				));
		}

		if (!$component instanceof Component) {
			throw new ComponentNotFound(sprintf(
				"Component %s #%s not found",
				$componentType->getValue(),
				$componentId->getValue(),
			));
		}

		return $component;
	}

	/**
	 * @param ComponentType $componentType
	 * @return array
	 */
	public function getList(ComponentType $componentType): array
	{
		switch ($componentType) {
			case ComponentType::MOTOR():
				return $this->entityManager->getRepository(Motor::class)->findAll();
			case ComponentType::VTX():
				return $this->entityManager->getRepository(Vtx::class)->findAll();
			case ComponentType::STACK():
				return $this->entityManager->getRepository(Stack::class)->findAll();
			case ComponentType::RECEPTOR():
				return $this->entityManager->getRepository(Receptor::class)->findAll();
			case ComponentType::PROPELLER():
				return $this->entityManager->getRepository(Propeller::class)->findAll();
			case ComponentType::FRAME():
				return $this->entityManager->getRepository(Frame::class)->findAll();
			case ComponentType::CAMERA():
				return $this->entityManager->getRepository(Camera::class)->findAll();
			case ComponentType::BATTERY():
				return $this->entityManager->getRepository(Battery::class)->findAll();
			default:
				return [];
		}
	}
}
