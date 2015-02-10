# WordPress Term Limits

> Limits terms (categories, post tags, custom taxonomy terms) on a per post type basis

### Is this a plugin?

No (not yet). It's a library (by now).

## How to install?

Just install/import it into your project using Composer

	composer create-project wcm/termlimits

Or clone the repository into your plugin directory using git

	git clone git@github.com:wecodemore/wcm-termlimit.git

Or simply download the ZIP and copy it into your plugin (not recommended).

## How to use?

Simple use case in a plugin:

	<?php /** Plugin Name: Term Limiter */
	if (
		! is_admin()
		or ( defined( 'DOING_AJAX' ) and DOING_AJAX )
	)
		return;

	$autoloader = __DIR__.'/vendor/autoload.php';
	/** @noinspection PhpIncludeInspection */
	file_exists( $autoloader )
		and require_once $autoloader;

	use WCM\TermLimit,
		WCM\TermLimit\Models;

	add_action( 'save_post', function( $post_id )
	{
		$boundaries = new Limiter(
			new Models\Post( $post_id ),
			new Models\Categories
		);

		// Change the min/max range of needed/allowed terms
		$boundaries->setRange( range( 5, 10 ) );

		// Change the post types the limit should get applied to
		$boundaries->setTypes( [ 'post', 'page' ] );

		// Check if the Amount of categories added is within the min/max range
		var_dump( $boundaries->inRange() );

		// Check if the limit should be applied to the current post type
		var_dump( $boundaries->isAllowedType() );
	} );

There are by now two classes that you can use:

1. `Models\Categories` to limit categories
1. `Models\Tags` to limit post tags

### The @TODO List

I haven't tested limiting custom taxonomy terms by now, but it shouldn't be a problem.
In case you inspected this (just add a quick example plugin to your stack and look at the `$_POST`
array inside a callback/action hooked to `save_post`), then please file a Pull Request and I will
craft a third class that extends the `AbstractTaxon` that will allow adding custom taxonomy names
and limit the amount of terms.

Also, there's by now nothing built in to do something in case the limit was exceeded or the
needed threshold not reached (min/max taxons). Example: add a notification. The problem with this
is that I have no idea what should happen in that case. Should we nuke all added terms? What if
20 are allowed and the user added 21? Should we just cut off one? If yes: Which one? Etc.
As you can see, there're a lot of possible UX mine traps and I have by now no idea how to solve
them. To be honest: This was just a very quick side project as it is something that is often
requested. If you have any idea how to go on this, feel free to open a pull request to discuss
your ideas. Thanks in advance.

## License

_WCM TermLimits_ is licensed under the MIT. Do whatever you want and feel comfortable with it.
Still a tweet or similar and a star here on GitHub won't hurt, right?