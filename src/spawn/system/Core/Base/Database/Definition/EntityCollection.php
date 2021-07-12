<?php declare(strict_types=1);

namespace spawn\system\Core\Base\Database\Definition;

use spawn\system\Core\Contents\Collection\Collection;

class EntityCollection extends Collection {

    protected string $containedEntityType;

    public function __construct(string $containedEntityType)
    {
        $this->containedEntityType = $containedEntityType;
    }

    public function getContainedEntityType(): string {
        return $this->getContainedEntityType();
    }

    //TODO: test this
    public function add($value) {
        if($value instanceof $this->containedEntityType) {
            $this->collection[] = $value;
        }
    }

}