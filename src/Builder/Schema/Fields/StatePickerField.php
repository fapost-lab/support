<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * Flow-state path input. Maps to the Vue `StatePickerField` component
 * — monospace input with `VariablePicker`.
 */
final class StatePickerField extends Field
{
    protected function type(): string
    {
        return 'state-picker';
    }
}
