<?php 
namespace Site\Views;

use Site\Base\Collection as Base;
use Site\Views\Data;

class Collection extends Base
{
    public function append(object $item): void 
    {
        if (!$item instanceof Data) {
            throw new \InvalidArgumentException(
                "Expected Data object instance"
            );
        }
        parent::append($item);
    }

    public function getNth(int $index): Data 
    {
        $item = parent::getNth($index);
        if (!$item instanceof Data) {
            throw new \InvalidArgumentException(
                "Expected Data object instance at index $index."
            );
        }
        return $item;
    }
}    
?>