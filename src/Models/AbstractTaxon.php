<?php

namespace WCM\TermLimit\Models;

/**
 * Class AbstractTaxon
 * @package WCM\TermLimit\Models
 */
abstract class AbstractTaxon extends \ArrayObject implements TaxonInterface
{
	public function getIterator()
	{
		return new \ArrayIterator( $this );
	}
}