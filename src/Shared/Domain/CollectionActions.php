<?php

declare(strict_types=1);

namespace XcelirateQuote\Shared\Domain;

Trait CollectionActions
{
    abstract protected function items(): array;

    public function count(): int
    {
        return count($this->items());
    }

    public function map($callback): static
    {
        $items = array_map(
            $callback,
            $this->items()
        );

        return new static($items);
    }

    public function filter($callback): static
    {
        $items = array_filter(
            $this->items(),
            $callback
        );

        return new static($items);
    }

    public function take(int $amount): static
    {
        $items = array_slice($this->items(), 0, $amount);

        return new static($items);
    }
}
