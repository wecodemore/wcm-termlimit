<?php

namespace WCM\TermLimit;

/**
 * Interface RangeLimitInterface
 * @package WCM\TermLimit
 */
interface RangeLimitInterface
{
	/**
	 * @param array $range
	 * @return void
	 */
	public function setRange( Array $range = [ 0, 1, 2 ] );

	/**
	 * @return bool
	 */
	public function inRange();
}