<?php

namespace glen\PhpCsFixerConfig;

use ArrayAccess;
use Traversable;

class RuleBuilder implements ArrayAccess
{
    /** @var array */
    private $rules;

    public function __construct(array $rules = null)
    {
        $this->rules = $rules;
    }

    /**
     * @param array|Traversable $rules
     */
    public function applyRules($rules)
    {
        foreach ($rules as $rule => $options) {
            $this->rules[$rule] = $options;
        }
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param mixed $offset
     * @return bool true on success or false on failure
     */
    public function offsetExists($offset)
    {
        return isset($this->rules[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed can return all value types
     */
    public function offsetGet($offset)
    {
        return $this->rules[$offset];
    }

    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->rules[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @see https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->rules[$offset]);
    }
}
