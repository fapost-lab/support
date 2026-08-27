<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema;

/**
 * Abstract base for every config-schema field.
 *
 * Subclasses register a `type()` string that maps 1:1 to the Vue
 * renderer's `FIELD_COMPONENTS` table and may layer their own
 * type-specific attributes on top via {@see typeSpecificAttributes()}.
 */
abstract class Field
{
    protected ?string $label = null;

    protected ?string $help = null;

    protected mixed $default = null;

    protected mixed $placeholder = null;

    protected bool $required = false;

    /**
     * @var array<int|string, mixed>|null
     */
    protected ?array $visibleWhen = null;

    public function __construct(public readonly string $name)
    {
    }

    abstract protected function type(): string;

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function help(string $text): static
    {
        $this->help = $text;

        return $this;
    }

    public function default(mixed $value): static
    {
        $this->default = $value;

        return $this;
    }

    public function placeholder(mixed $value): static
    {
        $this->placeholder = $value;

        return $this;
    }

    public function required(bool $required = true): static
    {
        $this->required = $required;

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * Short form `['field.path' => $expectedValue]` is sugar for an
     * equality check at the dot-path. Verbose form is an array of
     * `['field' => ..., 'op' => 'equals'|'in'|'truthy', 'value' => ...]`
     * clauses, all combined with logical AND.
     *
     * @param  array<int|string, mixed>  $condition
     */
    public function visibleWhen(array $condition): static
    {
        $this->visibleWhen = $condition;

        return $this;
    }

    /**
     * Serialise into the wire shape the Vue renderer consumes.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $out = ['type' => $this->type()];

        if (null !== $this->label) {
            $out['label'] = $this->label;
        }
        if ($this->required) {
            $out['required'] = true;
        }
        if (null !== $this->placeholder) {
            $out['placeholder'] = $this->placeholder;
        }
        if (null !== $this->default) {
            $out['default'] = $this->default;
        }
        if (null !== $this->help) {
            $out['help'] = $this->help;
        }
        if (null !== $this->visibleWhen) {
            $out['visible_when'] = $this->visibleWhen;
        }

        foreach ($this->typeSpecificAttributes() as $key => $value) {
            if (null === $value) {
                continue;
            }
            $out[$key] = $value;
        }

        return self::normalizeEnums($out);
    }

    /**
     * Recursively unwrap any `UnitEnum` / `BackedEnum` in the structure.
     *
     * Backed enums emit their `value` (so callers can write
     * `SendMessageContentType::Image` instead of `::Image->value`).
     * Pure enums emit their `name`. Anything else is returned as-is.
     */
    private static function normalizeEnums(mixed $value): mixed
    {
        if ($value instanceof \BackedEnum) {
            return $value->value;
        }
        if ($value instanceof \UnitEnum) {
            return $value->name;
        }
        if (is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[$k] = self::normalizeEnums($v);
            }
            return $out;
        }

        return $value;
    }

    /**
     * Hook for subclasses to contribute their own keys to the wire
     * shape. Null values are filtered out so optional attributes don't
     * pollute the output.
     *
     * @return array<string, mixed>
     */
    protected function typeSpecificAttributes(): array
    {
        return [];
    }
}
