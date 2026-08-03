# FAPost Support

`fapost/support` holds **reusable Eloquent primitives** — a base model, opt-in model concerns and
the fluent config-schema builder. These are shared building blocks with no Core coupling, usable
by Core and by external Solutions/Plugins alike.

## Design rules

- **No dependency on Core.** `use App\...` is forbidden here. Support may depend on
  [`fapost/foundation`](https://github.com/fapost-lab/foundation) contracts, but never on concrete Core domain classes.
- **Primitives, not business logic.** A class that carries domain semantics belongs in a Core
  domain. A contract meant for external Solutions/Plugins belongs in Foundation. What lands here is
  the pure, reusable middle.

## Requirements

- PHP `^8.4`
- `illuminate/database` / `illuminate/support` `^11 || ^12`
- `fapost/foundation`

## Namespace

```
FAPost\Support\   →  src/
```

## What's inside

### `Models\BaseModel`

An abstract Eloquent model wiring three **opt-in** extension points. All are inert unless the model
declares the corresponding property:

| Concern | Opt-in property | Effect |
|---------|-----------------|--------|
| `HasComputedAttributes` | — (resolver-backed) | Computed/virtual attributes via `ModelAttributeResolverInterface`, falling back to Eloquent |
| `InteractWithUtilities` | `$utilitiesClass` | Delegates unknown method calls to a `ModelUtilityInterface` class |
| `InteractWithBuilder` | `$customBuilder` | Swaps in a custom Eloquent query builder |

> `HasComputedAttributes` and `InteractWithUtilities` resolve their collaborators via `app()` — an
> accepted infrastructure exception, since Eloquent instantiates models directly and bypasses
> constructor DI.

### `Concerns\HasUlidPrimaryKey`

ULID primary keys stored as PostgreSQL `uuid` (RFC-4122, lowercased), per the platform ID strategy.
Use it on any tenant-schema model that follows this convention.

```php
final class Contact extends BaseModel
{
    use HasUlidPrimaryKey;
}
```

### `Builder\Schema`

A fluent builder for the array shape returned by `NodeHandlerInterface::configSchema()`. `Schema`,
`Section` and the `Fields\*` classes produce exactly the wire format the Vue flow builder consumes,
so handlers can mix fluent and raw arrays during migration. Each field's `type()` maps 1:1 to the
renderer's `FIELD_COMPONENTS` table.

Available field types: `Text`, `Textarea`, `Number`, `Toggle`, `Select`, `EnumCards`, `Array`,
`Object`, `ObjectArray`, `KeyValue`, `Json`, `Duration`, `FlowPicker`, `StatePicker`.

```php
Schema::make()
    ->section(
        Section::make('General')->fields(
            TextField::make('label')->label('Label')->required(),
            ToggleField::make('enabled')->default(true),
        ),
    );
```

## Testing

## License

Licensed under the [Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0).
