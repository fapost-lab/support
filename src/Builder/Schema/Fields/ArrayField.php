<?php

declare(strict_types=1);

namespace Fapost\Support\Builder\Schema\Fields;

use Fapost\Support\Builder\Schema\Field;

/**
 * List of strings. Maps to the Vue `ArrayField` component with one
 * input per item and a "+ Add item" button.
 */
final class ArrayField extends Field
{
    protected function type(): string
    {
        return 'array';
    }
}
