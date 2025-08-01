<?php 
namespace Haskris\Base\Models;

class Hydrator
{
    /**
     * Hydrates an object using an indexed array and a property map.
     *
     * @param object $object The object to hydrate
     * @param array $data The indexed array of values
     * @param array $propertyOrder The property names in order matching the array
     * @return object The hydrated object
     */

    private static ?Hydrator $instance = null;
    
    public static function getInstance(): Hydrator
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function hydrate(
        object $object, 
        array $data, 
        array $propertyOrder
    ): object
    {
        foreach ($propertyOrder as $index => $property) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($object, $setter)) {
                $object->$setter($data[$index] ?? null);
            }
        }

        return $object;
    }
}

?>