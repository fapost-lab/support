<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * Numeric input. Maps to the Vue `TextField` component with
 * `type="number"`. Inline `min`/`max` validators surface as a red
 * rim while the author types, but the backend validator remains the
 * source of truth at save time.
 */
final class NumberField extends Field
{
    private int|float|null $min = null;

    private int|float|null $max = null;

    public function min(int|float $value): self
    {
        $this->min = $value;

        return $this;
    }

    public function max(int|float $value): self
    {
        $this->max = $value;

        return $this;
    }

    protected function type(): string
    {
        return 'number';
    }

    protected function typeSpecificAttributes(): array
    {
        return [
            'min' => $this->min,
            'max' => $this->max,
        ];
    }
}
