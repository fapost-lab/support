<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * Flow-state path input. Maps to the Vue `StatePickerField` component.
 *
 * Two render modes:
 *  - Default — monospace text input with `VariablePicker`. The author types
 *    a free-form path (`flow.foo`, `system.bar`, etc.) and may insert a
 *    snippet from the picker.
 *  - When {@see namespaces()} is set — strict dropdown over user-registered
 *    variables whose path starts with one of the allowed namespaces. Pair
 *    with {@see searchable()} for a search-input + popover variant.
 */
final class StatePickerField extends Field
{
    /** @var list<string|\BackedEnum>|null */
    private ?array $namespaces = null;

    private bool $searchable = false;

    protected function type(): string
    {
        return 'state-picker';
    }

    /**
     * Constrain suggestions to the given namespace prefixes. Accepts either
     * raw strings or `BackedEnum` cases (e.g.
     * {@see \Fapost\Foundation\Flow\Enums\StateNamespace}). Field::toArray
     * normalises enums to their string values on serialisation.
     *
     * Switches the renderer to a strict dropdown over matching user-registered
     * variables.
     *
     * @param  list<string|\BackedEnum>  $namespaces
     */
    public function namespaces(array $namespaces): self
    {
        $this->namespaces = $namespaces;

        return $this;
    }

    /**
     * Render the dropdown with a search input. Only meaningful together with
     * {@see namespaces()}.
     */
    public function searchable(bool $searchable = true): self
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    protected function typeSpecificAttributes(): array
    {
        return [
            'namespaces' => $this->namespaces,
            'searchable' => $this->searchable ? true : null,
        ];
    }
}
