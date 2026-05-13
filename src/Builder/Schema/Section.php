<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema;

/**
 * UI grouping inside a config schema. A section owns its own field
 * declarations; {@see Schema::toArray()} hoists them to the top of
 * the wire shape and writes the section meta (`key`, `label`, `icon`,
 * `fields`, `collapsed`) under the top-level `sections` array.
 */
final class Section
{
    private ?string $icon = null;

    private bool $collapsed = false;

    /**
     * @var array<int, Field>
     */
    private array $fields = [];

    public function __construct(
        public readonly string $key,
        public readonly string $label,
    ) {
    }

    public static function make(string $key, string $label): self
    {
        return new self($key, $label);
    }

    public function icon(string $name): self
    {
        $this->icon = $name;

        return $this;
    }

    public function collapsed(bool $collapsed = true): self
    {
        $this->collapsed = $collapsed;

        return $this;
    }

    /**
     * @param  array<int, Field>  $fields
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return array<int, Field>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Wire metadata for the top-level `sections` array. Note that
     * `fields` here is a list of names — the field definitions
     * themselves are hoisted to the top of the schema by
     * {@see Schema::toArray()}.
     *
     * @return array<string, mixed>
     */
    public function meta(): array
    {
        $meta = [
            'key'   => $this->key,
            'label' => $this->label,
        ];
        if (null !== $this->icon) {
            $meta['icon'] = $this->icon;
        }
        $meta['fields'] = array_map(static fn (Field $field): string => $field->name, $this->fields);
        if ($this->collapsed) {
            $meta['collapsed'] = true;
        }

        return $meta;
    }
}
