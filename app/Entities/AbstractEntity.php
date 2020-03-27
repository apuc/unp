<?php

namespace App\Entities;

abstract class AbstractEntity
{
    public function __construct($record, $event)
    {
    	$this->record 	= $record;
    	$this->event	= $event;
    }

    public static function create($record, $event)
    {
		$classname = get_called_class();
		$instance = new $classname($record, $event);

		return $instance;
    }

	public static function relation($parent, $record)
	{
		$classname = get_called_class();
		$instance = new $classname($record, $parent->event);
		$instance->property = $parent->property;

		return $instance->handleKey();
	}

	public function property($field, $property)
	{
		$name = 'field' . studly_case($field);

		$this->property = $property;

		return $this->$name();
	}

	public function id()
	{
		return $this->record->id;
	}

	abstract public function key();

	public function handleKey()
	{
		if (in_array($this->property, ['id', 'value']) AND (!isset($this->record)))
			return null;

		return $this->key();
	}
}
