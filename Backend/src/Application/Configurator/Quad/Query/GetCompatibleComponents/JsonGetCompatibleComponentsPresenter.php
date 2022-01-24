<?php

namespace App\Application\Configurator\Quad\Query\GetCompatibleComponents;

use App\Domain\Configurator\Component\Component;
use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Component\Query\GetCompatibleComponents\GetCompatibleComponentsPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonGetCompatibleComponentsPresenter implements GetCompatibleComponentsPresenter
{
	/**
	 * @var string|null
	 */
	private ?string $message = null;

	/**
	 * @var Component[]
	 */
	private array $components = [];

	/**
	 * @return mixed
	 */
	public function present(): mixed
	{
		if ($this->message) {
			return new JsonResponse($this->message, 503);
		}

		$components = [];
		foreach ($this->components as $component) {
			$reflectionComponent = new \ReflectionClass($component);
			$arrayComponent = [];
			foreach ($reflectionComponent->getProperties() as $prop) {
				$prop->setAccessible(true);
				if ($prop->getValue($component) instanceof ComponentId) {
					$value = (string) $prop->getValue($component);
				} elseif ($prop->getName() === 'tags') {
					$value = json_decode($prop->getValue($component));
				} else {
					$value = $prop->getValue($component);
				}

				$arrayComponent[$prop->getName()] = $value;
				$arrayComponent['componentType'] = $component->getType();
				$arrayComponent['amountPrice'] = $component->getPrice()->getAmount();
				$arrayComponent['amountCurrency'] = $component->getPrice()->getCurrency()->getValue();
			}

			$components[] = $arrayComponent;
		}

		return new JsonResponse($components, 200);
	}

	/**
	 * @param string $message
	 */
	public function error(string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @param Component ...$components
	 */
	public function success(Component ...$components): void
	{
		$this->components = $components;
	}
}
