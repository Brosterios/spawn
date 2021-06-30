<?php declare(strict_types=1);

namespace webu\system\Core\Contents\Collection;


use webu\system\Core\Contents\Collection\AbstractCollectionBase;

class Collection extends AbstractCollectionBase {

    protected array $collection = array();

    protected int $position = 0;



    protected function getByIndex(int $index) {
        return $this->collection[$index];
    }

    protected function getCurrentKey() {
        return $this->position;
    }




    /*
     *
     * Custom Functions
     *
     */

    public function add($value) {
        $this->collection[] = $value;
    }

    public function overwrite(array $collection) {
        $this->collection = $collection;
    }

    public function set(int $key, $value) {
        if(isset($this->collection[$key])) {
            $this->collection[$key] = $value;
        }
        else {
            $this->collection[] = $value;
        }
    }

    public function get(int $key) {
        if(isset($this->collection[$key])) {
            return $this->collection[$key];
        }

        return null;
    }

    public function sort(callable $sortingMethod) {
        uasort($this->collection, $sortingMethod);
    }

    public function filter(callable $filterMethod) {
        $this->collection = array_filter($this->collection, $filterMethod);
    }


    public function first() {
        return $this->get(0);
    }

    public function last() {
        $count = $this->count();
        return $this->get($count-1);
    }

    public function getArray(): array {
        return $this->collection;
    }

}