<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * `Record<string, string>` editor. Maps to the Vue `KeyValueField`
 * component — paired inputs, "+ Add" button, inline duplicate-key
 * warning.
 */
final class KeyValueField extends Field
{
    private ?string $keyLabel = null;

    private ?string $valueLabel = null;

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

    protected function type(): string
    {
        return 'key-value';
    }

    protected function typeSpecificAttributes(): array
    {
        return [
            'key_label'   => $this->keyLabel,
            'value_label' => $this->valueLabel,
        ];
    }
}
