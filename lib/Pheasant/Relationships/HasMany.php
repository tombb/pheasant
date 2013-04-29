<?php

namespace Pheasant\Relationships;

use \Pheasant\Collection;

/**
 * A HasMany relationship represents a 1 to N relationship.
 */
class HasMany extends RelationshipType
{
    /**
     * Constructor
     */
    public function __construct($class, $local, $foreign=null)
    {
        parent::__construct($class, $local, $foreign);
    }

    /* (non-phpdoc)
     * @see RelationshipType::get()
     */
    public function get($object, $key)
    {
        $query = $this->query(
            "{$this->foreign}=?", $object->get($this->local));

        return new Collection($this->class, $query, $this->adder($object));
    }

    /* (non-phpdoc)
     * @see RelationshipType::add()
     */
    public function add($object, $value)
    {
        $newValue = $object->{$this->local};

        if($newValue instanceof PropertyReference)
            $value->saveAfter($object);

        $value->set($this->foreign, $newValue);
    }

    /* (non-phpdoc)
     * @see RelationshipType::join()
     */
    public function join($table, $query, $joinType='innerJoin')
    {
        if($this->foreign == $this->local)
            return $query->$joinType($table, "USING($this->foreign)");
        else
            return $query->$joinType($table, "ON {$this->foreign}={$this->local}");
    }


}
