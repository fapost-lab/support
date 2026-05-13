<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * Single-line text input. Maps to the Vue `TextField` component with
 * `VariablePicker` integration for `{{path}}` substitution.
 */
final class TextField extends Field
{
    private ?string $regex = null;

    private ?string $regexMessage = null;

    /**
     * Inline regex validator. The renderer flags non-matching values
     * with a red rim + the supplied message, but doesn't block save —
     * backend validation is still the source of truth.
     */
    public function regex(string $pattern, ?string $message = null): self
    {
        $this->regex        = $pattern;
        $this->regexMessage = $message;

        return $this;
    }

    protected function type(): string
    {
        return 'string';
    }

    protected function typeSpecificAttributes(): array
    {
        return [
            'regex'         => $this->regex,
            'regex_message' => $this->regexMessage,
        ];
    }
}
