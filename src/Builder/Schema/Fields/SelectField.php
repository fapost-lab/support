<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * Dropdown select. Maps to the Vue `SelectField` component.
 *
 * Accepts either a flat list of values (`['get', 'post']`) or a
 * value→label map (`['get' => 'GET', 'post' => 'POST']`). The
 * renderer normalises both shapes before display.
 */
final class SelectField extends Field
{
    /**
     * @var array<int|string, mixed>|null
     */
    private ?array $options = null;

    /**
     * @param  array<int|string, mixed>  $options
     */
    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    protected function type(): string
    {
        return 'enum';
    }

    protected function typeSpecificAttributes(): array
    {
        return [
            'options' => $this->options,
        ];
    }
}
