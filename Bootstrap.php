<?php
/**
 * Plugin Name: Term Limiter
 * Plugin URI:  https://github.com/wecodemore/wcm-termlimit
 * Description: Limits the amount of terms a user needs/is allowed to for a (custom) post type
 * Version:     0.2
 * Author:      Franz Josef Kaiser <wecodemore@gmail.com>
 * Author URI:  http://unserkaiser.com
 * Text Domain: wcmtl
 * Domain Path: lang
 * Network:     false
 * License:     MIT
 *
 * Copyright 2015 Franz Josef Kaiser
 */

namespace WCM\TermLimit;

if (
	! is_admin()
	or ( defined( 'DOING_AJAX' ) and DOING_AJAX )
)
	return;

$autoloader = __DIR__.'/vendor/autoload.php';
/** @noinspection PhpIncludeInspection */
file_exists( $autoloader )
	and require_once $autoloader;


add_action( 'wp_loaded', function()
{
	load_plugin_textdomain(
		'wcmtl',
		false,
		sprintf( '%s/lang', dirname( plugin_basename(__FILE__) ) )
	);
} );

/**
 * Check if in the allowed range (and of allowed type)
 * and if not, abort and redirect to the origin request
 * and present the user an error.
 */
add_action( 'save_post', function( $post_id )
{
	$boundaries = ( new Limiter(
		new Models\Post( $post_id ),
		new Models\Categories
	) )
		// Change the min/max range of needed/allowed terms
		->setRange( apply_filters( 'wcm-term.limit', range( 0, 3 ) ) )
		// Change the post types the limit should get applied to
		->setTypes( apply_filters( 'wcm-term.types', [ 'post', ] ) );

	if (
		$boundaries->isAllowedType()
		and ! $boundaries->inRange()
		)
	{
		wp_safe_redirect( add_query_arg(
			'message',
			11,
			wp_get_referer() ?: $_SERVER['HTTP_REFERER']
		) );
		exit;
	}
} );

/**
 * Update Message
 */
add_filter( 'post_updated_messages', function( $messages )
{
	foreach ( [ 'post', 'page', ] as $type )
	{
		$messages[ $type ][11] = sprintf(
			__( 'Please chose at least %d terms', 'wcmtl' ),
			min( apply_filters( 'wcm-term.limit', range( 0, 3 ) ) )
		);
		$messages[ $type ][12] = __( 'Term limit exceeded', 'wcmtl' );
	}

	return $messages;
}, PHP_INT_MAX -1 );