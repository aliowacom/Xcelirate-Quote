<?php

declare(strict_types=1);

namespace XcelirateQuote\Shared\Domain;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;

abstract class Collection implements Countable, IteratorAggregate
{
    use CollectionActions;
    
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(private array $items)
    {
        $this->assertArrayOfType($items);
    }

    abstract protected function type(): string;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    protected function items(): array
    {
        return $this->items;
    }
    
    private function assertArrayOfType(array $items): void
    {
        $class = $this->type();

        foreach ($items as $item) {
            if (!$item instanceof $class) {
                throw new InvalidArgumentException(
                    sprintf('The object <%s> is not an instance of <%s>', $class, get_class($item))
                );
            }
        }
    }
}
