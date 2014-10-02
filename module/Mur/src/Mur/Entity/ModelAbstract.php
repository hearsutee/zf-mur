<?php
namespace Mur\Entity;


use Zend\Stdlib\ArraySerializableInterface;

//

abstract class ModelAbstract implements \ArrayAccess, ArraySerializableInterface
{

    public function offsetExists ($offset)
    {
        $value = null;
        $offset = ucfirst($offset);
        if (\method_exists($this, 'get'.$offset)) {
            $value = $this->{"get$offset"}();
        }

        return $value !== null;
    }

    public function offsetSet ($offset, $value)
    {
        $offset = ucfirst($offset);
        if (\method_exists($this, 'set'.ucfirst($offset))) {
            $this->{"set$offset"}($value);
        }
    }

    public function offsetGet ($offset)
    {
        if (\method_exists($this, 'get'.ucfirst($offset))) {
            return $this->{"get$offset"}();
        }
    }

    public function offsetUnset ($offset)
    {
        $this->offsetSet($offset, null);
    }

    public function getArrayCopy ()
    {
        return get_object_vars($this);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Stdlib\ArraySerializableInterface::exchangeArray()
     */
    public function exchangeArray(array $array)
    {
        return $this->setFromArray($array);
    }

    /**
     * Automated setter for all properties
     *
     * @param  array|Iterable $data
     * @return ModelAbstract
     * @throws Exception
     */
    public function setFromArray($data)
    {
        if (is_object($data)) {
            if ($data instanceof \ArrayObject) {
                $data = $data->getArrayCopy();
            } elseif (method_exists($data, 'toArray')) {
                $data = $data->toArray();
            } elseif (! $data instanceof \Iterator) {
                throw new \Exception("Model should be instanciated with an array or an Iterable object");
            }
        } elseif (! is_array($data)) {
            throw new \Exception("Model should be instanciated with an array or an Iterable object");
        }

        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }

        return $this;
    }
}
