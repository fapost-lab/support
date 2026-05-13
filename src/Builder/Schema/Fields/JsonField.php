<?php

declare(strict_types=1);

namespace FAPost\Support\Builder\Schema\Fields;

use FAPost\Support\Builder\Schema\Field;

/**
 * Raw JSON textarea. Maps to the Vue `JsonField` component. Value is
 * the parsed object/array, not the raw string.
 */
final class JsonField extends Field
{
    protected function type(): string
    {
        return 'json';
    }
}
