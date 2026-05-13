<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * Repeater of structured objects. Maps to the Vue `ObjectArrayField`
 * component — collapsible accordion per item with a per-row delete.
 */
final class ObjectArrayField extends Field
{
    /**
     * @var array<int, Field>
     */
    private array $itemFields = [];

    private ?string $itemLabel = null;

    private ?int $minItems = null;

    private ?int $maxItems = null;

    /**
     * @param  array<int, Field>  $fields
     */
    public function itemFields(array $fields): self
    {
        $this->itemFields = $fields;

        return $this;
    }

    /**
     * Template substituted into the collapsed row header, e.g.
     * `'{from_path} → {to_state}'`. Placeholders reference top-level
     * item keys.
     */
    public function itemLabel(string $template): self
    {
        $this->itemLabel = $template;

        return $this;
    }

    public function minItems(int $count): self
    {
        $this->minItems = $count;

        return $this;
    }

    public function maxItems(int $count): self
    {
        $this->maxItems = $count;

        return $this;
    }

    protected function type(): string
    {
        return 'object-array';
    }

    protected function typeSpecificAttributes(): array
    {
        $fieldsArr    = [];
        $requiredKeys = [];

        foreach ($this->itemFields as $field) {
            $fieldsArr[$field->name] = $field->toArray();
            if ($field->isRequired()) {
                $requiredKeys[] = $field->name;
            }
        }

        $item = ['fields' => $fieldsArr];
        if ([] !== $requiredKeys) {
            $item['required'] = $requiredKeys;
        }
        if (null !== $this->itemLabel) {
            $item['item_label'] = $this->itemLabel;
        }

        return [
            'item'      => $item,
            'min_items' => $this->minItems,
            'max_items' => $this->maxItems,
        ];
    }
}
