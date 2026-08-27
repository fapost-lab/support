<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * Nested group of fields under a single config key. Maps to the Vue
 * `ObjectField` component, which delegates to `SchemaFields` for the
 * sub-schema. The state path is `config[key].subkey`; the renderer
 * emits the whole sub-object on every change.
 */
final class ObjectField extends Field
{
    /**
     * @var array<int, Field>
     */
    private array $fields = [];

    /**
     * @param  array<int, Field>  $fields
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    protected function type(): string
    {
        return 'object';
    }

    protected function typeSpecificAttributes(): array
    {
        $fieldsArr    = [];
        $requiredKeys = [];

        foreach ($this->fields as $field) {
            $fieldsArr[$field->name] = $field->toArray();
            if ($field->isRequired()) {
                $requiredKeys[] = $field->name;
            }
        }

        return [
            'fields'   => $fieldsArr,
            'required' => [] === $requiredKeys ? null : $requiredKeys,
        ];
    }
}
