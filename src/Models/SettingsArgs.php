<?php

namespace WCM\TermLimit\Models;

/**
 * Class SettingsArgs
 * @package WCM\TermLimit\Models
 */
class SettingsArgs extends \ArrayObject implements SettingsArgsInterface
{
	/**
	 * @param string $name
	 * @param string $label
	 * @param array  $data
	 */
	public function __construct( $name, $label = '', Array $data = [] )
	{
		$this->setFlags( \ArrayObject::STD_PROP_LIST );

		$this->offsetSet( 'name', strtolower( trim( $name ) ) );

		if ( ! empty( $label ) )
			$this->offsetSet( 'label', $label );

		foreach ( $data as $index => $value )
			$this->offsetSet( $index, $value );
	}

	public function getIterator()
	{
		return new \ArrayIterator( get_object_vars( $this ) );
	}

	public function getID()
	{
		return $this->name;
	}

	public function getLabel()
	{
		return $this->label;
	}

	public function offsetExists( $offset )
	{
		return property_exists( $this, $offset );
	}

	public function offsetGet( $offset )
	{
		return $this->offsetExists( $offset )
			? $this->{$offset}
			: null;
	}

	public function offsetSet( $offset, $value )
	{

		$this->{$offset} = $value;
	}

	public function offsetUnset( $offset )
	{
		unset( $this->{$offset} );
	}
}