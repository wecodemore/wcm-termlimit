<?php

namespace WCM\TermLimit;

/**
 * Class Limiter
 * @package WCM\TermLimit
 */
class Limiter implements TypeLimitInterface, RangeLimitInterface
{
	/** @type Models\PostInterface model */
	private $post;

	/** @var Array */
	private $types = [ 'post', ];

	/** @var Array */
	private $range = [ 0, 1, 2, ];

	/**
	 * @param Models\PostInterface  $post
	 * @param Models\TaxonInterface $taxons
	 */
	public function __construct(
		Models\PostInterface $post,
		Models\TaxonInterface $taxons )
	{
		$this->post   = $post;
		$this->taxons = $taxons;
	}

	/**
	 * Just an internal helper method
	 * Do not use to redirect to messages
	 * Could be wrong just because the post type isn't limited
	 * @return bool
	 */
	public function valid()
	{
		return
			$this->isAllowedType()
			&& $this->inRange();
	}

	/**
	 * @param array $types
	 * @return $this
	 */
	public function setTypes( Array $types = [] )
	{
		! empty( $types ) and $this->types = $types;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isAllowedType()
	{
		$type = $this->post->getType();
		return
			! is_wp_error( $type )
			&& in_array( $type, $this->types );
	}

	/**
	 * @param array $range
	 * @return $this
	 */
	public function setRange( Array $range = [] )
	{
		! empty( $range ) and $this->range = $range;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function inRange()
	{
		return in_array(
			absint( count( $this->taxons ) ),
			$this->range
		);
	}
}