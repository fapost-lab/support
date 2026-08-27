<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * Boolean checkbox. Maps to the Vue `ToggleField` component.
 */
final class ToggleField extends Field
{
    protected function type(): string
    {
        return 'boolean';
    }
}
