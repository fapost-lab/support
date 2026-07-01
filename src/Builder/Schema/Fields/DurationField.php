<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * Duration picker — a number input paired with a unit selector
 * (minutes / hours / days / weeks / months / years). Maps to the Vue
 * `DurationField` component.
 *
 * The stored value is an ISO 8601 duration string (e.g. `PT24H`, `P7D`),
 * parseable by {@see \DateInterval}. `units()` narrows the offered units;
 * the default exposes the full set.
 */
final class DurationField extends Field
{
    /**
     * @var list<string>|null
     */
    private ?array $units = null;

    /**
     * Restrict the selectable units. Allowed: minutes, hours, days,
     * weeks, months, years.
     *
     * @param  list<string>  $units
     */
    public function units(array $units): self
    {
        $this->units = $units;

        return $this;
    }

    protected function type(): string
    {
        return 'duration';
    }

    protected function typeSpecificAttributes(): array
    {
        return [
            'units' => $this->units,
        ];
    }
}
