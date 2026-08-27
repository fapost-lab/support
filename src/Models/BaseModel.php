<?php

declare(strict_types=1);

namespace Fapost\Support\Models;

use Fapost\Support\Concerns\HasComputedAttributes;
use Fapost\Support\Concerns\InteractWithBuilder;
use Fapost\Support\Concerns\InteractWithUtilities;
use Illuminate\Database\Eloquent\Model;

/**
 * Base Eloquent model providing three opt-in extension points:
 *
 * - {@see HasComputedAttributes}  — computed/virtual attributes via ModelAttributeResolverInterface
 * - {@see InteractWithUtilities}  — delegate unknown method calls to a utility class ($utilitiesClass)
 * - {@see InteractWithBuilder}    — swap in a custom query builder class ($customBuilder)
 *
 * All extensions are inert unless the model declares the corresponding property.
 */
abstract class BaseModel extends Model
{
    use HasComputedAttributes;
    use InteractWithBuilder;
    use InteractWithUtilities;
}
