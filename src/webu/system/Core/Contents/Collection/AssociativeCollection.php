<?php

namespace webu\system\Core\Contents\Collection;

use Iterator;
use Countable;
use webu\system\Core\Contents\Collection\AbstractCollectionBase;

class AssociativeCollection extends AbstractCollectionBase {

    protected array $collection = array();
    protected array $keys = array();
    protected int $position = 0;

    /*
     *
     * Custom Functions
     *
     */

    public function set($key, $value) {
        $isNewEntry = (false == isset($this->collection[$key]));
        $this->collection[$key] = $value;

        if($isNewEntry) {
            $this->generateOrUpdateKeys();
        }
    }

    public function get($key) {
        if(isset($this->collection[$key])) {
            return $this->collection[$key];
        }

        if(isset($this->keys[$key])) {
            return $this->collection[$this->keys[$key]];
        }

        return null;
    }


    public function sort(callable $sortingMethod) {
        uasort($this->collection, $sortingMethod);
        $this->generateOrUpdateKeys();
    }


    public function filter(callable $filterMethod) {
        $this->collection = array_filter($this->collection, $filterMethod);
        $this->generateOrUpdateKeys();
    }


    protected function generateOrUpdateKeys() {
        $this->keys = [];
        foreach($this->collection as $key => $item) {
            $this->keys[] = $key;
        }
    }

    protected function getByIndex(int $index)
    {
        return $this->collection[$this->keys[$index]];
    }

    protected function getCurrentKey()
    {
        if(isset($this->keys[$this->position])) {
            return $this->keys[$this->position];
        }

        return count($this->keys);
    }
}