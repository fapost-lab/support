<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * Multi-line text input. Maps to the Vue `TextareaField` component
 * with `VariablePicker` integration.
 */
final class TextareaField extends Field
{
    protected function type(): string
    {
        return 'text';
    }
}
