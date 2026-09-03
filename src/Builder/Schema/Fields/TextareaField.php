<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * Multi-line text input. Maps to the Vue `TextareaField` component
 * with `VariablePicker` integration.
 */
final class TextareaField extends Field
{
    private bool $variablePicker = true;

    protected function type(): string
    {
        return 'text';
    }

    /**
     * Drop the inline variable picker. For text that never reaches runtime
     * (builder-only notes), an inserted `{{ ... }}` would never resolve, so
     * offering the picker is misleading.
     */
    public function withoutVariablePicker(): static
    {
        $this->variablePicker = false;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    protected function typeSpecificAttributes(): array
    {
        return $this->variablePicker ? [] : ['variable_picker' => false];
    }
}
