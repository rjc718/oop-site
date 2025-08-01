<?php 
namespace Haskris\Base\Models;

class ArrayTools
{  
    private static ?ArrayTools $instance = null;
    
    public static function getInstance(): ArrayTools
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function leftJoinGenerator(array $array1, array $array2, array $keys): \Generator
    {
        $indexedArray2 = [];
        foreach ($array2 as $item) {
            $compositeKey = implode('|', array_map(fn($k) => $item[$k] ?? '', $keys));
            $indexedArray2[$compositeKey] = $item;
        }

        foreach ($array1 as $item1) {
            $compositeKey = implode('|', array_map(fn($k) => $item1[$k] ?? '', $keys));
            yield isset($indexedArray2[$compositeKey])
                ? array_merge($item1, $indexedArray2[$compositeKey])
                : $item1;
        }
    }

    public function leftJoin(array $array1, array $array2, array $keys): array 
    {
        $indexedArray2 = [];
        foreach ($array2 as $item) {
            $compositeKey = implode('|', array_map(fn($k) => $item[$k] ?? '', $keys));
            $indexedArray2[$compositeKey] = $item;
        }

        $result = [];
        foreach ($array1 as $item1) {
            $compositeKey = implode('|', array_map(fn($k) => $item1[$k] ?? '', $keys));
            $result[] = isset($indexedArray2[$compositeKey])
                ? array_merge($item1, $indexedArray2[$compositeKey])
                : $item1;
        }

        return $result;
    }

    public function rightJoin(array $array1, array $array2, array $keys): array 
    {
        $indexedArray1 = [];
        foreach ($array1 as $item) {
            $compositeKey = implode('|', array_map(fn($k) => $item[$k] ?? '', $keys));
            $indexedArray1[$compositeKey] = $item;
        }

        $result = [];
        foreach ($array2 as $item2) {
            $compositeKey = implode('|', array_map(fn($k) => $item2[$k] ?? '', $keys));
            $result[] = isset($indexedArray1[$compositeKey])
                ? array_merge($indexedArray1[$compositeKey], $item2)
                : $item2;
        }

        return $result;
    }

    public function innerJoin(array $array1, array $array2, array $keys): array 
    {
        $indexedArray2 = [];
        foreach ($array2 as $item) {
            $compositeKey = implode('|', array_map(fn($k) => $item[$k] ?? '', $keys));
            $indexedArray2[$compositeKey] = $item;
        }

        $result = [];
        foreach ($array1 as $item1) {
            $compositeKey = implode('|', array_map(fn($k) => $item1[$k] ?? '', $keys));
            if (isset($indexedArray2[$compositeKey])) {
                $result[] = array_merge($item1, $indexedArray2[$compositeKey]);
            }
        }

        return $result;
    }

    public function fullOuterJoin(array $array1, array $array2, array $keys): array 
    {
        $indexed1 = [];
        $indexed2 = [];

        foreach ($array1 as $item) {
            $key = implode('|', array_map(fn($k) => $item[$k] ?? '', $keys));
            $indexed1[$key] = $item;
        }

        foreach ($array2 as $item) {
            $key = implode('|', array_map(fn($k) => $item[$k] ?? '', $keys));
            $indexed2[$key] = $item;
        }

        $allCompositeKeys = array_unique(array_merge(array_keys($indexed1), array_keys($indexed2)));

        $result = [];
        foreach ($allCompositeKeys as $key) {
            $item1 = $indexed1[$key] ?? [];
            $item2 = $indexed2[$key] ?? [];
            $result[] = array_merge($item1, $item2);
        }

        return $result;
    }

    public function removeRowsWithNullValue(array $array, string $key): array 
    {
        return array_values(array_filter($array, function ($row) use ($key) {
            return isset($row[$key]) && $row[$key] !== null;
        }));
    }

    public function removeRowsWithNullOrEmptyValue(array $array, string $key): array 
    {
        return array_values(array_filter($array, function ($row) use ($key) {
            return isset($row[$key]) && trim($row[$key]) !== '';
        }));
    }


    public function sortByKeyAsc(array $array, string $sortKey): array 
    {
        usort($array, fn($a, $b) => $a[$sortKey] <=> $b[$sortKey]);
        return $array;
    }

    public function sortByKeyDesc(array $array, string $sortKey): array 
    {
        usort($array, fn($a, $b) => $b[$sortKey] <=> $a[$sortKey]);
        return $array;
    }

    public function normalizeArray(array $array): array
    {
        $allKeys = $this->getAllKeys($array);
        return array_map(fn($row) => $this->normalizeKeys($row, $allKeys), $array);
    }

    private function normalizeKeys(array $row, array $allKeys): array 
    {
        foreach ($allKeys as $key) {
            if (!array_key_exists($key, $row)) {
                $row[$key] = null;
            }
        }
        return $row;
    }

    private function getAllKeys(array ...$arrays): array
    {
        $allKeys = [];
        foreach ($arrays as $array) {
            foreach ($array as $row) {
                $allKeys = array_merge($allKeys, array_keys($row));
            }
        }
        return array_values(array_unique($allKeys));
    }

    public function sayHi(): string
    {
        return '<p>Hello World!</p>';
    }
}
