<?php

namespace WCM\TermLimit\Models;

/**
 * Class Post
 * @package WCM\TermLimit
 */
class Post implements PostInterface
{
	/** @var \WP_Post|\WP_Error */
	private $post;

	/** @var string|null */
	private $type;

	/**
	 * @param int $post_id
	 */
	public function __construct( $post_id = 0 )
	{
		$this->post = ! is_int( $post_id )
			? new \WP_Error( 'term-limit', 'Input needs to be an integer' )
			: get_post( $post_id );

		is_null( $this->post )
			and $this->post = new \WP_Error( 'term-limit', 'Invalid post ID' );

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getType()
	{
		return is_wp_error( $this->post )
			? null
			: $this->post->post_type;
	}
}