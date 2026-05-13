<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema;

/**
 * Root builder for the array shape returned by
 * `NodeHandlerInterface::configSchema()`.
 *
 * The wire format consumed by the Vue renderer is documented in
 * `docs/builder-config-schema-reference.md`. {@see toArray()} produces
 * exactly that shape — nothing more, nothing less — so handlers can
 * mix fluent and raw arrays during migration and tests can compare
 * the two byte-for-byte (after key ordering).
 */
final class Schema
{
    /**
     * @var array<int, string>
     */
    private array $required = [];

    /**
     * @var array<int, Section>
     */
    private array $sections = [];

    /**
     * @var array<int, Field>
     */
    private array $topLevelFields = [];

    public static function make(): self
    {
        return new self();
    }

    /**
     * Explicit top-level required list — mirrors per-field
     * `->required()` flags for handlers that want both (UI asterisk
     * plus an explicit contract at the top of the schema).
     *
     * @param  array<int, string>  $names
     */
    public function required(array $names): self
    {
        $this->required = array_values($names);

        return $this;
    }

    public function section(Section $section): self
    {
        $this->sections[] = $section;

        return $this;
    }

    /**
     * Append top-level fields. Useful for sectionless schemas — the
     * renderer falls back to a single auto-section called
     * "Configuration" when no sections are declared.
     *
     * @param  array<int, Field>  $fields
     */
    public function fields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->topLevelFields[] = $field;
        }

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $out = [];

        if ($this->required !== []) {
            $out['required'] = $this->required;
        }

        if ($this->sections !== []) {
            $out['sections'] = array_map(
                static fn (Section $section): array => $section->meta(),
                $this->sections,
            );

            foreach ($this->sections as $section) {
                foreach ($section->getFields() as $field) {
                    $out[$field->name] = $field->toArray();
                }
            }
        }

        foreach ($this->topLevelFields as $field) {
            $out[$field->name] = $field->toArray();
        }

        return $out;
    }
}
