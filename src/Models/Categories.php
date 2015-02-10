<?php

namespace WCM\TermLimit\Models;

/**
 * Class Categories
 * @package WCM\TermLimit\Models
 */
class Categories extends AbstractTaxon implements TaxonInterface
{
	public function __construct()
	{
		array_map( function( $item )
		{
			$this->append( filter_var(
				$item,
				FILTER_VALIDATE_INT,
				[ FILTER_NULL_ON_FAILURE, ]
			) );
		}, $_POST['post_category'] );

		// Also take newly added (but not yet submitted) cats into account
		$this->append( filter_input(
			INPUT_POST,
			'newcategory',
			FILTER_SANITIZE_STRING,
			[ FILTER_NULL_ON_FAILURE, ]
		) );
	}

	/**
	 * @return int|null
	 */
	public function getNewCatParent()
	{
		return filter_input(
			INPUT_POST,
			'newcategory_parent',
			FILTER_SANITIZE_NUMBER_INT,
			[ FILTER_NULL_ON_FAILURE ]
		);
	}
}