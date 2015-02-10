<?php

namespace WCM\TermLimit;

interface TypeLimitInterface
{
	/**
	 * @param array $types
	 * @return mixed
	 */
	public function setTypes( Array $types = [ 'post', ] );

	/**
	 * @return bool
	 */
	public function isAllowedType();
}