<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * `Record<string, string>` editor. Maps to the Vue `KeyValueField`
 * component — paired inputs, "+ Add" button, inline duplicate-key
 * warning.
 */
final class KeyValueField extends Field
{
    private ?string $keyLabel = null;

    private ?string $valueLabel = null;

    protected function type(): string
    {
        return 'key-value';
    }

    public function keyLabel(string $label): self
    {
        $this->keyLabel = $label;

        return $this;
    }

    public function valueLabel(string $label): self
    {
        $this->valueLabel = $label;

        return $this;
    }

    protected function typeSpecificAttributes(): array
    {
        return [
            'key_label' => $this->keyLabel,
            'value_label' => $this->valueLabel,
        ];
    }
}
