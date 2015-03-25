<?php

namespace WCM\TermLimit;

class RangeFieldController
{
	/** @var string */
	private $root;

	public function __construct( $root )
	{
		$this->root = $root;
	}

	public function setup()
	{
		$taxonomies = $this->getTaxonomies();
		$post_types = $this->getPostTypes( $taxonomies );
		foreach ( $post_types as $type => $taxonomies )
		{
			$field = new OptionsFieldBuilder(
				$this->getArgs( $type, $taxonomies ),
				"{$this->root}src/templates/range.html.php",
				'reading'
			);
			$field->build();
		}
	}

	public function getArgs( $type, Array $taxonomies )
	{
		$type_obj = get_post_type_object( $type );
		return new Models\SettingsArgs(
			"term-limit-{$type}",
			sprintf( __( 'Set min/max for %s', 'wcmtl' ), $type_obj->labels->singular_name ),
			[
				'min'     => 1,
				'max'     => 5,
				'type'    => $type,
				'options' => $taxonomies,
				'desc'    => __( 'Minimum / Maximum', 'wcmtl' ),
			]
		);
	}

	public function getTaxonomies()
	{
		return wp_list_filter(
			$GLOBALS['wp_taxonomies'],
			[ 'show_ui' => true, ]
		);
	}

	public function getPostTypes( $taxonomies )
	{
		$types = [];
		foreach ( $taxonomies as $tax )
		{
			foreach ( $tax->object_type as $type )
			{
				$types[ $type ][ ] = [
					'name'  => $tax->name,
					'label' => $tax->labels->singular_name,
				];
			}
		}

		return $types;
	}
}