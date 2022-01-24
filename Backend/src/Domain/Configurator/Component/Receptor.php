<?php

namespace App\Domain\Configurator\Component;

use App\Domain\Configurator\Component\Service\ComponentDiscriminator;
use App\Domain\Configurator\Enum\ComponentType;
use App\Domain\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is Receptor entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Receptor extends BaseComponent
{
	/**
	 * @param string $name
	 * @param Money $price
	 * @param bool $isFavorite
	 * @param string $imgUrl
	 * @param string $tags
	 * @param string $description
	 * @param ComponentDiscriminator $componentDiscriminator
	 */
	public function __construct(
		string $name,
		Money $price,
		bool $isFavorite,
		string $imgUrl,
		string $tags,
		string $description,
		ComponentDiscriminator $componentDiscriminator
	) {
		parent::__construct(
			$name,
			$price,
			$isFavorite,
			$imgUrl,
			$tags,
			$description,
			$componentDiscriminator
		);
	}

    /**
     * @param Component $component
     * @return bool
     */
    public function isCompatibleComponent(Component $component): bool
    {
        return true;
    }

	/**
	 * @return ComponentType
	 */
	public function getType(): ComponentType
	{
		return ComponentType::RECEPTOR();
	}
}
