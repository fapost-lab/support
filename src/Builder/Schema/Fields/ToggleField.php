<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

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
