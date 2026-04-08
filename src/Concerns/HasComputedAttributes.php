<?php

declare(strict_types=1);

namespace FAPost\Support\Concerns;

use FAPost\Foundation\Contracts\ModelAttributeResolverInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Adds computed attribute support to Eloquent models via {@see ModelAttributeResolverInterface}.
 *
 * Core binds ModelAttributeResolverInterface to ModelAttributeRegistry in AppServiceProvider.
 * The trait resolves the interface from the container — an accepted infrastructure exception
 * because Eloquent instantiates models directly, bypassing constructor DI.
 *
 * @mixin Model
 */
trait HasComputedAttributes
{
    /**
     * Resolve computed attributes registered via {@see ModelAttributeResolverInterface}.
     *
     * Falls back to Eloquent's default attribute resolution when the attribute is not registered.
     *
     * @throws \Illuminate\Contracts\Container\CircularDependencyException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __get($key): mixed
    {
        // Acceptable: Eloquent instantiation bypasses constructor DI.
        $resolver = app(ModelAttributeResolverInterface::class);

        if ($resolver->has(static::class, (string) $key)) {
            return $resolver->resolve(static::class, (string) $key, $this);
        }

        return parent::__get($key);
    }

    /**
     * Convert model to an attribute array and append registry attributes marked with append=true.
     *
     * Note: resolver closures may access relations; callers should eager-load to avoid N+1 queries.
     *
     * @return array<string, mixed>
     */
    public function attributesToArray(): array
    {
        $attributes = parent::attributesToArray();

        // Acceptable: Eloquent instantiation bypasses constructor DI.
        $resolver = app(ModelAttributeResolverInterface::class);
        $extra    = $resolver->serializable(static::class);

        foreach ($extra as $name => $resolverFn) {
            $attributes[$name] = $resolverFn($this);
        }

        return $attributes;
    }
}
