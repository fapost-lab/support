<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * Radio-card enum. Maps to the Vue `EnumCardsField` component — a richer
 * alternative to {@see SelectField} where each option renders as a
 * full-width card with an optional icon, hint line and colour accent.
 *
 * Options are full descriptors rather than a flat list:
 *   ['value' => 'success', 'label' => 'Success', 'icon' => '✓',
 *    'hint' => 'Flow finished as expected', 'accent' => 'sage']
 */
final class EnumCardsField extends Field
{
    /**
     * @var list<array{value: string, label: string, icon?: string, hint?: string, accent?: string}>|null
     */
    private ?array $options = null;

    protected function type(): string
    {
        return 'enum-cards';
    }

    /**
     * @param  list<array{value: string, label: string, icon?: string, hint?: string, accent?: string}>  $options
     */
    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    protected function typeSpecificAttributes(): array
    {
        return [
            'options' => $this->options,
        ];
    }
}
