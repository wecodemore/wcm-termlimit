<?php
/**
 * Plugin Name: (WCM) Term Limiter
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
 * (c) 2015 Franz Josef Kaiser
 */

if ( ! is_admin() )
	return;

$autoloader = __DIR__.'/vendor/autoload.php';
/** @noinspection PhpIncludeInspection */
file_exists( $autoloader )
	and require_once $autoloader;

use WCM\TermLimit\Limiter,
	WCM\TermLimit\Models,
	WCM\TermLimit\SettingsField,
	WCM\TermLimit\SettingsView,
	WCM\TermLimit\RangeFieldController;

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
	$post = new Models\Post( $post_id );

	$limits = get_option( "term-limit-{$post->getType()}" );
	if ( ! $limits )
		return;

	$boundaries = ( new Limiter(
		$post,
		$cats = new Models\Categories
	) )
		// Change the min/max range of needed/allowed terms
		->setRange( apply_filters( 'wcm-term.limit', range( 0, 3 ) ) )
		// Change the post types the limit should get applied to
		->setTypes( apply_filters( 'wcm-term.types', [ 'post', ] ) );

	if (
		$boundaries->isAllowedType()
		and !$boundaries->inRange()
		)
	{
		wp_safe_redirect(
			add_query_arg(
				'message',
				11,
				wp_get_referer() ?: $_SERVER[ 'HTTP_REFERER' ]
			)
		);
		exit;
	}
} );

/**
 * Update Message
 */
add_filter( 'post_updated_messages', function( $messages )
{
	/** @var \WP_Post $post */
	$post = get_post();
	$limits = get_option( "term-limit-{$post->post_type}" );
	foreach ( array_keys( $limits ) as $taxonomy )
	{
		$messages[ $post->post_type ][11] = sprintf(
			__( 'Please chose at least %d terms', 'wcmtl' ),
			min( apply_filters( 'wcm-term.limit', range( 0, 3 ) ) )
		);
		$messages[ $post->post_type ][12] = __( 'Term limit exceeded', 'wcmtl' );
	}

	return $messages;
}, PHP_INT_MAX -1 );


$range = new RangeFieldController( plugin_dir_path( __FILE__ ) );
add_action( 'admin_init', [ $range, 'setup' ] );