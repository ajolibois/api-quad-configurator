<?php

namespace App\Application\Configurator\Component\Command\Add;

use App\Domain\Configurator\Component\Camera;
use App\Domain\Configurator\Component\Command\AddComponent\AddComponent;
use App\Domain\Configurator\Component\Command\AddComponent\AddComponentHandler;
use App\Domain\Configurator\Component\Frame;
use App\Domain\Configurator\Component\Motor;
use App\Domain\Configurator\Component\Propeller;
use App\Domain\Configurator\Component\Stack;
use App\Domain\Configurator\Component\Vtx;
use App\Domain\Configurator\Enum\AntennaConnection;
use App\Domain\Configurator\Enum\CameraSize;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Configurator\Enum\EscMaxCurrent;
use App\Domain\Configurator\Enum\FlightControllerProc;
use App\Domain\Configurator\Enum\FlightStyle;
use App\Domain\Configurator\Enum\FrameArmThickness;
use App\Domain\Configurator\Enum\FrameSize;
use App\Domain\Configurator\Enum\MotorKv;
use App\Domain\Configurator\Enum\MotorStatorSize;
use App\Domain\Configurator\Enum\PropellerPitch;
use App\Domain\Configurator\Enum\StackHole;
use App\Domain\Configurator\Enum\UartCount;
use App\Domain\Configurator\Enum\VtxHole;
use App\Domain\Configurator\Enum\VtxInputPower;
use App\Domain\Configurator\Enum\VtxPower;
use App\Domain\Currency;
use App\Domain\Money;
use App\Infrastructure\Configurator\Discriminator\AlphaNumericComponentDiscriminator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class AddComponentController extends AbstractController
{
	/**
	 * AddComponentController constructor.
	 *
	 * @param AddComponentHandler $handler
	 */
	public function __construct(private AddComponentHandler $handler) { }

	/**
	 * @Route("/component/add", name="add_component", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function execute(Request $request): JsonResponse
	{
		try {
			$content = json_decode($request->getContent());

			$componentType = new ComponentType($content->componentType);

			switch ($componentType) {
				case ComponentType::VTX():
					$component = $this->createVtx($content);
					break;
				case ComponentType::STACK():
					$component = $this->createStack($content);
					break;
				case ComponentType::PROPELLER():
					$component = $this->createPropeller($content);
					break;
				case ComponentType::MOTOR():
					$component = $this->createMotor($content);
					break;
				case ComponentType::FRAME():
					$component = $this->createFrame($content);
					break;
				case ComponentType::CAMERA():
					$component = $this->createCamera($content);
					break;
				default:
					return new JsonResponse('UNKNOWN_COMPONENT', 404);
			}


			$command = new AddComponent($component);
			$presenter = new JsonAddComponentPresenter();
			$this->handler->handle($command, $presenter);
		} catch (\Exception $e) {
			return new JsonResponse($e->getMessage(), 500);
		}

		return $presenter->present();
	}

	/**
	 * @param object $content
	 * @return Vtx
	 */
	private function createVtx(object $content): Vtx
	{
		// TODO: check content

		return new Vtx(
			$content->name,
			new Money($content->price, new Currency($content->currency)),
			new VtxHole((string) $content->vtxHole),
			(bool) $content->isNumeric,
			new AntennaConnection((string) $content->antennaConnection),
			new VtxPower((string) $content->vtxPower),
			new VtxInputPower((string) $content->vtxInputPower),
			(bool) $content->isFavorite,
			(string) $content->imgUrl,
			json_encode($content->tags),
			(string) $content->description,
			new AlphaNumericComponentDiscriminator()
		);
	}

	/**
	 * @param object $content
	 * @return Stack
	 */
	private function createStack(object $content): Stack
	{
		// TODO: check content

		return new Stack(
			$content->name,
			new Money($content->price, new Currency($content->currency)),
			new VtxInputPower((string) $content->vtxInputPower),
			new FlightControllerProc((string) $content->flightControllerProc),
			new StackHole((string) $content->stackHole),
			new UartCount((string) $content->uartCount),
			(bool) $content->isNumericCompatible,
			(bool) $content->isAnalogCompatible,
			new EscMaxCurrent((string) $content->escMaxCurrent),
			(bool) $content->isFavorite,
			(string) $content->imgUrl,
			json_encode($content->tags),
			(string) $content->description,
			new AlphaNumericComponentDiscriminator()
		);
	}

	/**
	 * @param object $content
	 * @return Propeller
	 */
	private function createPropeller(object $content): Propeller
	{
		// TODO: check content

		return new Propeller(
			$content->name,
			new Money($content->price, new Currency($content->currency)),
			new FrameSize((string) $content->frameSize),
			new PropellerPitch((string) $content->propellerPitch),
			(bool) $content->isFavorite,
			(string) $content->imgUrl,
			json_encode($content->tags),
			(string) $content->description,
			new AlphaNumericComponentDiscriminator()
		);
	}

	/**
	 * @param object $content
	 * @return Motor
	 */
	private function createMotor(object $content): Motor
	{
		// TODO: check content

		return new Motor(
			$content->name,
			new Money($content->price, new Currency($content->currency)),
			new MotorKv((string) $content->kv),
			new MotorStatorSize((string) $content->statorSize),
			new FlightStyle((string) $content->flightStyle),
			(bool) $content->isFavorite,
			(string) $content->imgUrl,
			json_encode($content->tags),
			(string) $content->description,
			new AlphaNumericComponentDiscriminator()
		);
	}

	/**
	 * @param object $content
	 * @return Frame
	 */
	private function createFrame(object $content): Frame
	{
		// TODO: check content

		return new Frame(
			$content->name,
			new Money($content->price, new Currency($content->currency)),
			new FrameSize((string) $content->frameSize),
			new FrameArmThickness((string) $content->armThickness),
			new VtxHole((string) $content->vtxHole),
			new CameraSize((string) $content->cameraSize),
			new StackHole((string) $content->stackHole),
			(bool) $content->isFavorite,
			(string) $content->imgUrl,
			json_encode($content->tags),
			(string) $content->description,
			new AlphaNumericComponentDiscriminator()
		);
	}

	/**
	 * @param object $content
	 * @return Camera
	 */
	private function createCamera(object $content): Camera
	{
		// TODO: check content

		return new Camera(
			$content->name,
			new Money($content->price, new Currency($content->currency)),
			new CameraSize((string) $content->cameraSize),
			(bool) $content->isNumeric,
			(bool) $content->isFavorite,
			(string) $content->imgUrl,
			json_encode($content->tags),
			(string) $content->description,
			new AlphaNumericComponentDiscriminator()
		);
	}
}
