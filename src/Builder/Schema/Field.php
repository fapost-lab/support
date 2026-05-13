<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema;

use FAPost\Support\Builder\Schema\Fields\ArrayField;
use FAPost\Support\Builder\Schema\Fields\JsonField;
use FAPost\Support\Builder\Schema\Fields\KeyValueField;
use FAPost\Support\Builder\Schema\Fields\NumberField;
use FAPost\Support\Builder\Schema\Fields\ObjectArrayField;
use FAPost\Support\Builder\Schema\Fields\ObjectField;
use FAPost\Support\Builder\Schema\Fields\SelectField;
use FAPost\Support\Builder\Schema\Fields\StatePickerField;
use FAPost\Support\Builder\Schema\Fields\TextField;
use FAPost\Support\Builder\Schema\Fields\TextareaField;
use FAPost\Support\Builder\Schema\Fields\ToggleField;

/**
 * Abstract base for every config-schema field.
 *
 * Subclasses register a `type()` string that maps 1:1 to the Vue
 * renderer's `FIELD_COMPONENTS` table and may layer their own
 * type-specific attributes on top via {@see typeSpecificAttributes()}.
 *
 * Static factories on this class are the canonical entry points —
 * authors typically write `Field::string('url')->required()` rather
 * than `new TextField('url')`. The factory return types are concrete
 * so chainable methods stay typed (e.g. `min()` only available on
 * NumberField).
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

    public function __construct(public readonly string $name) {}

    abstract protected function type(): string;

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

        if ($this->label !== null) {
            $out['label'] = $this->label;
        }
        if ($this->required) {
            $out['required'] = true;
        }
        if ($this->placeholder !== null) {
            $out['placeholder'] = $this->placeholder;
        }
        if ($this->default !== null) {
            $out['default'] = $this->default;
        }
        if ($this->help !== null) {
            $out['help'] = $this->help;
        }
        if ($this->visibleWhen !== null) {
            $out['visible_when'] = $this->visibleWhen;
        }

        foreach ($this->typeSpecificAttributes() as $key => $value) {
            if ($value === null) {
                continue;
            }
            $out[$key] = $value;
        }

        return $out;
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

    public static function string(string $name): TextField
    {
        return new TextField($name);
    }

    public static function text(string $name): TextareaField
    {
        return new TextareaField($name);
    }

    public static function number(string $name): NumberField
    {
        return new NumberField($name);
    }

    public static function select(string $name): SelectField
    {
        return new SelectField($name);
    }

    public static function toggle(string $name): ToggleField
    {
        return new ToggleField($name);
    }

    public static function array(string $name): ArrayField
    {
        return new ArrayField($name);
    }

    public static function json(string $name): JsonField
    {
        return new JsonField($name);
    }

    public static function statePicker(string $name): StatePickerField
    {
        return new StatePickerField($name);
    }

    public static function keyValue(string $name): KeyValueField
    {
        return new KeyValueField($name);
    }

    public static function object(string $name): ObjectField
    {
        return new ObjectField($name);
    }

    public static function objectArray(string $name): ObjectArrayField
    {
        return new ObjectArrayField($name);
    }
}
