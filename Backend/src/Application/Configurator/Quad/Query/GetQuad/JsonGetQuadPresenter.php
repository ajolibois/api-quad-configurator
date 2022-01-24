<?php

namespace App\Application\Configurator\Quad\Query\GetQuad;

use App\Domain\Configurator\Component\ComponentId;
use App\Domain\Configurator\Quad\Quad;
use App\Domain\Configurator\Quad\QuadId;
use App\Domain\Configurator\Quad\Query\GetQuad\GetQuadPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Domain\Configurator\Component\Component;

final class JsonGetQuadPresenter implements GetQuadPresenter
{
	/**
	 * @var ?string
	 */
	private ?string $message = null;

	/**
	 * @var ?Quad
	 */
	private ?Quad $quad = null;

	/**
	 * @return JsonResponse
	 */
	public function present(): JsonResponse
	{
		if ($this->message) {
			return new JsonResponse($this->message, 503);
		}

		if (!$this->quad) {
			return new JsonResponse(['INTERNAL_ERROR'], 500);
		}

		$reflectionQuad = new \ReflectionClass($this->quad);
		$arrayQuad = [];
		foreach ($reflectionQuad->getProperties() as $quadProp) {
			$quadProp->setAccessible(true);
			$quadValue = $quadProp->getValue($this->quad);
			if ($quadValue instanceof Component) {
				$component = $quadValue;
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

				$quadValue = $arrayComponent;
			}

			if ($quadValue instanceof QuadId) {
				$quadValue = $quadValue->getValue();
			}

			$arrayQuad[$quadProp->getName()] = $quadValue;
		}

		return new JsonResponse($arrayQuad, 200);
	}

	/**
	 * @param string $message
	 */
	public function error(string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @param Quad $quad
	 */
	public function success(Quad $quad): void
	{
		$this->quad = $quad;
	}
}
