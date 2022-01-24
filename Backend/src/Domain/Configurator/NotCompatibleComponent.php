<?php

namespace App\Domain\Configurator;

use App\Domain\Configurator\Component\Component;

final class NotCompatibleComponent extends \InvalidArgumentException
{
    /**
     * NotCompatibleComponent constructor.
     *
     * @param Component $component
     */
    public function __construct(private Component $component)
    {
        parent::__construct("NOT_COMPATIBLE_COMPONENT", 400);
    }

    /**
     * @return Component
     */
    public function getComponent(): Component
    {
        return $this->component;
    }
}
