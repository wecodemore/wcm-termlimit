# WordPress Term Limits

> Limits terms (categories, post tags, custom taxonomy terms) on a per post type basis

Needs **PHP 5.4+** to run. Will break with lower PHP versions.

### Is this a plugin?

**Yes** <strike>No (not yet). It's a library (by now).</strike>

## How to install?

You can simply download it and are ready to go. Still the following options are preferred.

Or just install/import it into your project using Composer

	composer create-project wcm/termlimits

Or clone the repository into your plugin directory using git

	git clone git@github.com:wecodemore/wcm-termlimit.git

## How to use?

Per default, there is a minimum of `0` terms that need to get added.
The maximum is `3`. And the limit only applies for the `post` post type.

To alter the limit or the type, there are two filters that you can use in
a small child plugin:

```
<?php
/** Plugin Name: Term Limit config */

// Apply a minimum of 3 and a limit of 6 terms
add_filter( 'wcm-term.limit', function( Array $limit )
{
    return range( 3, 6 );
} );

// Apply the limit to the following post types
add_filter( 'wcm-term.types', function( Array $types )
{
    return [ 'post', 'my-custom-post-type', ];
} );
```

In case you want to extend your limit to custom taxonomies, you will
also have to write a quick extension/class to account for that:

```
class MyCustomTaxonomy extends AbstractTaxon implements TaxonInterface
{
	public function __construct()
	{
		$this->append( explode( ",", filter_var(
			$_POST['tax_input']['custom_terms'],
			FILTER_SANITIZE_STRING,
			[ FILTER_NULL_ON_FAILURE, ]
		) ) );
	}
}
```

To see what exactly you should take as input/`$_POST` value, use
the following mini-plugin to dump your `save_post` action.

```
<?php
/** Plugin Name: (Debug) Dump $_POST during save_post */
add_action( 'save_post', function()
{
	exit( var_dump( $_POST ) );
} );
```

**Important:** Make sure that you have at least FTP access and can actually edit
or remove the plugin. Else you will get stuck there. This will break (exit) your
request and present you with a dump of the post.

### The @TODO List

Custom taxonomy terms.

Also, there's by now nothing built in to do something in case the limit was exceeded or the
needed threshold not reached (min/max taxons). The plugin lets everything go through
and just informs the user. One idea so far: extend the notification. The problem with this
is that I have no idea what should happen in that case. Should we nuke all added terms? What if
20 are allowed and the user added 21? Should we just cut off one? If yes: Which one? Etc.
As you can see, there're a lot of possible UX mine traps and I have by now no idea how to solve
them. To be honest: This was just a very quick side project as it is something that is often
requested. If you have any idea how to go on this, feel free to open a pull request to discuss
your ideas. Thanks in advance.

## License

_WCM TermLimits_ is licensed under the MIT. Do whatever you want and feel comfortable with it.
Still a tweet or similar and a star here on GitHub won't hurt, right?