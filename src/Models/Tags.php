<?php

namespace WCM\TermLimit\Models;

/**
 * Class Tags
 * @package WCM\TermLimit\Models
 */
class Tags extends AbstractTaxon implements TaxonInterface
{
	public function __construct()
	{
		$this->append( explode( ",", filter_var(
			$_POST['tax_input']['post_tag'],
			FILTER_SANITIZE_STRING,
			[ FILTER_NULL_ON_FAILURE, ]
		) ) );

		$this->append( explode( ",", filter_var(
			$_POST['tax_input']['new_tag'],
			FILTER_SANITIZE_STRING,
			[ FILTER_NULL_ON_FAILURE, ]
		) ) );
	}
}