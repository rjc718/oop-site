<?php
namespace Haskris\Base;

use InvalidArgumentException;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

class Collection implements IteratorAggregate
{
    protected array $items = [];

    public function __construct(array $items = []) {
        foreach ($items as $item) {
            $this->append($item);
        }
    }

    public function append(object $item): void {
        $this->items[] = $item;
    }

    public function appendArray(array $items): void {
        foreach ($items as $item) {
            $this->append($item);
        }
    }

    public function appendList(Collection $items): void {
        foreach ($items as $item) {
            $this->append($item);
        }
    }

    public function removeNth(int $index): void {
        if (!isset($this->items[$index])) {
            throw new InvalidArgumentException("No item found at index $index.");
        }
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function getNth(int $index): object {
        if (!isset($this->items[$index])) {
            throw new InvalidArgumentException("No item found at index $index.");
        }
        return $this->items[$index];
    }

    public function getAll(): array {
        return $this->items;
    }

    public function count(): int {
        return count($this->items);
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->items);
    }
}
?>