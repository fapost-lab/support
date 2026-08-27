<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * Flow reference picker. Maps to the Vue `FlowPickerField` component — a
 * searchable dropdown over the assistant's flows that stores the selected
 * `flow.id` (UUID), not the name.
 *
 * The list is sourced from the builder runtime store, not the schema, so
 * no options are declared here. Use {@see excludeCurrent()} to keep (or
 * drop) the current flow from the list — dropped by default to prevent a
 * flow from referencing itself.
 */
final class FlowPickerField extends Field
{
    private bool $excludeCurrent = true;

    protected function type(): string
    {
        return 'flow-picker';
    }

    /**
     * Whether to hide the current flow from the picker. Defaults to true —
     * a flow referencing itself (e.g. a `subflow` call) is almost always a
     * mistake.
     */
    public function excludeCurrent(bool $exclude = true): self
    {
        $this->excludeCurrent = $exclude;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    protected function typeSpecificAttributes(): array
    {
        // Only emit when it diverges from the component default (true), to
        // keep the wire shape minimal.
        return [
            'exclude_current' => $this->excludeCurrent ? null : false,
        ];
    }
}
