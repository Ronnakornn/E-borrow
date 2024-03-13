<?php

namespace App\Enums\Concerns;

trait Utilities
{
    /**
     * Retrieves an array of values from the cases array.
     *
     * @return array An array of values
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    /**
     * Retrieve an array of names from the cases array.
     *
     * @return array The array of names.
     */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    /**
     * Generates an associative array with labels as keys and values as values.
     *
     * @return array
     */
    public static function array(): array
    {
        return collect(static::cases())
            ->when(
                method_exists(static::class, 'getLabel'),
                fn ($cases) =>
                $cases->mapWithKeys(fn ($case) => [
                    ($case?->value ?? $case->name) => $case->getLabel() ?? $case->name,
                ]),
                fn ($cases) =>
                $cases->mapWithKeys(fn ($case) => [
                    ($case?->value ?? $case->name) => $case->name,
                ])
            )
            ->toArray();
    }
}