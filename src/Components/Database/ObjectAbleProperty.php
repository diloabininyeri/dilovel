<?php


namespace App\Components\Database;

/**
 * Class ObjectAbleProperty
 * @package App\Models\Objectable
 */
abstract class ObjectAbleProperty
{
    /**
     * @var
     */
    protected $property;

    /**
     * ObjectAbleProperty constructor.
     * @param $property
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * @return mixed
     *
     */
    public function __toString()
    {
        return $this->property;
    }
}
